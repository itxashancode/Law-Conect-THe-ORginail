# Database Updates for Law Connect

Please execute the following SQL commands in your phpMyAdmin or SQL console to support the new Lawyer Approval and Banning workflow.

### 1. Update Users Table
Add a status column to the users table to handle banning.
```sql
ALTER TABLE users ADD COLUMN status VARCHAR(20) DEFAULT 'active' AFTER user_type;
```

### 2. Update Lawyers Table
Ensure the status column exists and supports the necessary states. If it doesn't exist, use the first command. If it does, you can use it to reset or verify.
```sql
-- Add status if missing
-- ALTER TABLE lawyers ADD COLUMN status VARCHAR(20) DEFAULT 'pending';

-- Update all existing lawyers to approved (optional, for existing data)
UPDATE lawyers SET status = 'approved' WHERE status IS NULL;
```

### 3. Verify Constraints
Ensure that `consultation_fee` and `experience_years` can handle the data types.
```sql
ALTER TABLE lawyers MODIFY COLUMN consultation_fee DECIMAL(10, 2) DEFAULT 0.00;
ALTER TABLE lawyers MODIFY COLUMN experience_years INT DEFAULT 0;
```
