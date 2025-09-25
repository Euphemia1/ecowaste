-- EcoWaste Database Schema
-- Run this SQL in your Supabase SQL Editor

-- Create users table
CREATE TABLE IF NOT EXISTS public.users (
    id UUID PRIMARY KEY REFERENCES auth.users(id) ON DELETE CASCADE,
    email VARCHAR(255) NOT NULL UNIQUE,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    account_type VARCHAR(20) NOT NULL DEFAULT 'individual' CHECK (account_type IN ('individual', 'organization')),
    email_verified BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT NOW()
);

-- Create updated_at trigger function
CREATE OR REPLACE FUNCTION update_updated_at_column()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = NOW();
    RETURN NEW;
END;
$$ language 'plpgsql';

-- Create trigger for users table
CREATE TRIGGER update_users_updated_at 
    BEFORE UPDATE ON public.users 
    FOR EACH ROW 
    EXECUTE FUNCTION update_updated_at_column();

-- Enable Row Level Security (RLS)
ALTER TABLE public.users ENABLE ROW LEVEL SECURITY;

-- Create policies for users table
-- Users can read their own data
CREATE POLICY "Users can view own profile" ON public.users
    FOR SELECT USING (auth.uid() = id);

-- Users can update their own data
CREATE POLICY "Users can update own profile" ON public.users
    FOR UPDATE USING (auth.uid() = id);

-- Allow authenticated users to insert their own data during signup
CREATE POLICY "Users can insert own profile" ON public.users
    FOR INSERT WITH CHECK (auth.uid() = id);

-- Optional: Create an index for better performance
CREATE INDEX IF NOT EXISTS idx_users_email ON public.users(email);
CREATE INDEX IF NOT EXISTS idx_users_account_type ON public.users(account_type);

-- Grant permissions
GRANT USAGE ON SCHEMA public TO authenticated;
GRANT ALL ON public.users TO authenticated;
GRANT ALL ON public.users TO service_role;

-- Insert test data (optional - remove in production)
-- This will only work after a user signs up through the auth system
-- INSERT INTO public.users (id, email, first_name, last_name, account_type, email_verified, is_active)
-- VALUES 
--     ('11111111-1111-1111-1111-111111111111', 'test@example.com', 'Test', 'User', 'individual', true, true);

COMMENT ON TABLE public.users IS 'User profiles table linked to Supabase auth.users';
COMMENT ON COLUMN public.users.account_type IS 'Type of account: individual or organization';
COMMENT ON COLUMN public.users.email_verified IS 'Whether the email has been verified';
COMMENT ON COLUMN public.users.is_active IS 'Whether the user account is active';