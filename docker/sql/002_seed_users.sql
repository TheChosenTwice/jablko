-- Seed data for users table
-- NOTE: Never store plain text passwords. Generate a password hash with PHP and paste it into the VALUES below.
-- Example PHP one-liner to generate a hash (run on your machine):
-- php -r "echo password_hash('your_test_password', PASSWORD_DEFAULT);"

-- Replace <HASH_GOES_HERE> with the output from the PHP command.

INSERT INTO `users` (`username`, `email`, `password`) VALUES
('testuser', 'testuser@example.com', '<HASH_GOES_HERE>');

-- If you already added a user manually in Adminer, you can skip running this seed.

