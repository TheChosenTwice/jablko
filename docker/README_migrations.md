Migration files for the project (Adminer / repeatable setup)

What I added
- `docker/sql/001_create_users_table.sql` - CREATE TABLE statement for `users`.
- `docker/sql/002_seed_users.sql` - example seed with instructions for generating a password hash.

How to apply in Adminer (http://localhost:8080)
1. Open Adminer and log in using your DB credentials (see `docker/.env` for DB user/password if needed).
2. Select the database `vaiicko_db` (or your DB name).
3. Open the SQL tab.
4. To (re)create the table, paste the contents of `001_create_users_table.sql` and execute.
   - If the table already exists, DROP it first if you want to re-run the migration.
5. To insert the seed user, first generate a password hash using PHP locally:

   php -r "echo password_hash('your_test_password', PASSWORD_DEFAULT);"

   Then paste the resulting hash into `002_seed_users.sql` replacing `<HASH_GOES_HERE>` and execute the INSERT in Adminer.

Notes
- Keeping migrations under `docker/sql/` makes it easy to re-run the schema on a new environment.
- For automated migration in CI or Docker, we can later add a small PHP or shell script that runs these SQL files against the database. Ask me and I can add that.

