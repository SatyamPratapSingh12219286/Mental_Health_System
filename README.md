# Mental Health Assessment

This project is a simple PHP-based mental health self-assessment tool (PHQ-9 and GAD-7).

Quick start (local):

1. Ensure PHP and MySQL are installed (XAMPP is a good option on Windows).
2. Place the project in your web root (e.g., `c:/xampp/htdocs/DjangoProject`).
3. Create the database `mental_health_assessment` and the `assessment_results` table (SQL provided in repo).
4. Start a PHP server for quick testing:

```bash
php -S 0.0.0.0:8000 -t "c:/xampp/htdocs/DjangoProject"
```

Then open `http://localhost:8000/`.

Repository push instructions:

- Initialize and commit locally (already done by the helper script):
  - git init
  - git add .
  - git commit -m "Initial commit"

- Create a repository on GitHub and add a remote, then push:
  - git remote add origin https://github.com/<your-username>/<repo-name>.git
  - git branch -M main
  - git push -u origin main

If you want, I can create a `Dockerfile`, `docker-compose.yml`, and `.env.example` to make deployment easier.
