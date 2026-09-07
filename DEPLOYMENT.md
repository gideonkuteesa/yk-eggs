# YK Eggs V1 Deployment Checklist

## GitHub
Create a repository, then upload the contents of `frontend` if you are using GitHub Pages or another static host.

Do not upload your real `.env` file.

## Static hosting
The frontend folder must be the published/root directory.

Required files:
- index.html
- styles.css
- app.js
- manifest.json
- service-worker.js
- assets/

## API hosting
Deploy the `backend` folder to a Node.js-compatible host.

Environment variables:
PORT
DB_HOST
DB_PORT
DB_USER
DB_PASSWORD
DB_NAME

## Database
Run `database/yk_eggs.sql` on your MySQL server.

## Production
Use HTTPS for the frontend and API. Do not expose database credentials in frontend JavaScript.
