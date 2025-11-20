-- Migration: Allow NULL password for personil
-- This allows creating personil records without password initially
-- Password can be set later through external program

-- Make password column nullable
ALTER TABLE personil 
ALTER COLUMN password DROP NOT NULL;

-- Add comment to explain
COMMENT ON COLUMN personil.password IS 'Password hash - can be NULL if not yet set. Use external program to set password after personil creation.';
