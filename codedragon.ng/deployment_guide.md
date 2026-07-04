# CandyTech Fintech Platform - Phase 2 Documentation

This guide covers the setup and deployment for the CandyTech platform, including local development with webhooks and production deployment requirements.

## 1. Local Development Setup

To test payment and notification features locally, you must create a "tunnel" so that Monnify and VTPass can send webhook notifications to your computer.

### Webhook Tunneling
If you don't have a fixed IP, use **Localtunnel** or **SSH** to expose your port 8000:

**Option A: Localtunnel (Recommended)**
```bash
npx localtunnel --port 8000 --subdomain candytech-test
```
*Your URL will be: `https://candytech-test.loca.lt`*

**Option B: SSH Tunnel**
```bash
ssh -R 80:localhost:8000 lhr.life
```
*Your URL will be provided in the terminal (e.g., `https://random-id.lhr.life`).*

### Configuration in Admin Dashboard
Once your tunnel is running:
1.  Log in as Admin.
2.  Go to **Admin Settings**.
3.  Ensure the following URLs are updated in your **Monnify** and **VTPass** Dashboards:
    - **Monnify Webhook:** `https://your-tunnel-url.loca.lt/webhook/monnify`
    - **VTPass Webhook:** `https://your-tunnel-url.loca.lt/webhook/vtpass`

---

## 2. Production Deployment Settings

When moving to a live server (cPanel, VPS, etc.), follow these critical steps:

### A. Environment Variables (.env)
Ensure your `.env` file is properly configured. Most settings are now database-driven via the Admin Panel, but the core Laravel settings must be correct:
```env
APP_NAME=CandyTech
APP_ENV=production
APP_DEBUG=false
APP_URL=https://candytech.ng

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

### B. Cron Jobs (Automated Tasks)
The platform relies on automated tasks for Price Syncing and Auto-Subscriptions. You **MUST** add a Cron Job to your server.

**cPanel/Crontab Command:**
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```
*This command runs the Laravel scheduler every minute, which then triggers:*
- **Price Sync:** Every 8 hours (`vtpass:sync-prices`).
- **Auto-Subscriptions:** Daily at midnight (`subscriptions:process`).
- **Balance Monitoring:** Every 5 minutes (`vtpass:monitor-balance`).

### C. Folder Permissions
Ensure the following directories are writable by the web server:
- `storage/`
- `bootstrap/cache/`

### D. SSL Requirement
Webhooks **require** HTTPS. Ensure your production domain has a valid SSL certificate (Let's Encrypt is recommended).

---

## 3. Feature Management

### Pricing Engine
- Located at: `/admin/pricing`
- Allows setting bulk commission rules (Percentage/Fixed) and manual price overrides for all VTPass services.

### WhatsApp Notification Engine
- **Providers Supported:** Termii, Sendchamp.
- **Settings:** Configure API Keys and Sender IDs in the Admin Settings panel.
- **Features:** Auto-Wallet funding alerts, PIN/Token delivery, and Admin Broadcasts.

### Auto-Subscription
- Users can toggle "Auto-Renew" on Airtime and Data purchases.
- The system will automatically attempt to renew the service on the due date if the user has a sufficient wallet balance.

---

## 4. Troubleshooting

- **Balance not reflecting?** Check if the Webhook URL in your Monnify dashboard matches your current tunnel/live URL.
- **Prices not updating?** Check if the Cron Job is running. You can run it manually once using `php artisan vtpass:sync-prices`.
- **WhatsApp not sending?** Verify your API keys and ensure your account has enough credit on Termii/Sendchamp.
