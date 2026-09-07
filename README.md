# YK Eggs V1 — iPhone-first PWA

This package contains the rebuilt YK Eggs V1 with:

- iPhone-first responsive PWA interface
- Egg price/profit calculator
- UGX currency
- Calculation history stored locally in the browser
- Dashboard with totals
- Installable PWA manifest + service worker
- MySQL database schema
- Node.js/Express API for persistent database storage

## 1. Test the frontend immediately

The PWA should be served over HTTP/HTTPS (not by double-clicking `index.html`).

From the `frontend` folder, one simple option is:

```bash
npx serve .
```

Then open the address shown by `serve` on your phone and computer.

For iPhone installation:
1. Open the deployed HTTPS site in Safari.
2. Tap Share.
3. Tap Add to Home Screen.

## 2. Set up MySQL

Create the database by importing:

`database/yk_eggs.sql`

Using MySQL command line:

```bash
mysql -u root -p < database/yk_eggs.sql
```

Or import the SQL file through phpMyAdmin.

## 3. Run the API

Open a terminal in `backend`:

```bash
npm install
```

Copy `.env.example` to `.env` and enter your MySQL password.

Then:

```bash
npm start
```

API:
- GET `/api/health`
- POST `/api/calculations`
- GET `/api/calculations`
- GET `/api/dashboard`

## 4. Important V1 note

The current frontend works fully without the API because history is saved in `localStorage`. This makes it easy to use while offline.

The Node/MySQL API is included so V2 can connect the PWA to a central online database, login system, users, stock, customers and synchronized history.

## 5. Deployment

Recommended structure:
- Frontend: any static HTTPS host
- Backend: Node.js host
- Database: MySQL-compatible hosted database

Once deployed, change the frontend's save/load logic to call the API instead of only localStorage.

## 6. iPhone requirements

For camera/advanced PWA browser features, use HTTPS in production. `localhost` is also treated as a secure context during local development.

## Troubleshooting

### Service worker 404
Make sure `service-worker.js` is in the same folder as `index.html` and the site is served through HTTP/HTTPS.

### Manifest icon 404
This starter package includes SVG fallback branding; replace `assets/icon-192.png` and `assets/icon-512.png` with actual PNG icons before production.

### MySQL connection error
Check:
- MySQL server is running
- DB_HOST
- DB_PORT
- DB_USER
- DB_PASSWORD
- DB_NAME

### npm command not recognized
Install Node.js LTS first, restart the terminal, then run `node -v` and `npm -v`.
