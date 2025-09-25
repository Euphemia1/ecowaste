# EcoWaste Setup Guide

## Prerequisites
- Supabase account and project
- Node.js and npm installed

## Setup Instructions

### 1. Supabase Configuration

1. **Create a Supabase project** at https://supabase.com
2. **Get your project credentials**:
   - Go to Settings > API in your Supabase dashboard
   - Copy your Project URL and anon key
3. **Update `.env.local`** with your actual credentials:
   ```
   NEXT_PUBLIC_SUPABASE_URL=https://your-project.supabase.co
   NEXT_PUBLIC_SUPABASE_ANON_KEY=your_anon_key_here
   ```

### 2. Database Setup

1. **Go to SQL Editor** in your Supabase dashboard
2. **Run the SQL script** from `supabase-schema.sql`:
   - Copy the entire content of the file
   - Paste it into the SQL Editor
   - Click "Run" to create the tables and policies

### 3. Install Dependencies and Run

1. **Install packages**:
   ```bash
   npm install
   ```

2. **Start the development server**:
   ```bash
   npm run dev
   ```

3. **Open the app** at http://localhost:3000

### 4. Test the Application

1. **Go to signup page**: http://localhost:3000/signup
2. **Create an account** with:
   - First Name, Last Name
   - Email and password (min 8 characters)
   - Choose account type (Individual or Organization)
   - Agree to terms
3. **Sign up** - you should see success message
4. **Go to login page**: http://localhost:3000/login
5. **Sign in** with your credentials
6. **Access dashboard** - should redirect automatically

### 5. Troubleshooting

**If signup shows 404:**
- Check that Supabase URL and keys are correct in `.env.local`
- Ensure the database schema has been created (run the SQL script)
- Check browser console for error messages

**If authentication doesn't work:**
- Verify Supabase credentials
- Check that the `users` table was created
- Look at browser Network tab for failed requests

**Common issues:**
- Make sure `.env.local` is in the root directory (same level as `package.json`)
- Restart the dev server after updating environment variables
- Check Supabase logs in the dashboard for any database errors

### 6. Features

✅ **User Registration**: Individual and Organization accounts
✅ **Authentication**: Login/logout with session management  
✅ **Dashboard**: Different views based on account type
✅ **Route Protection**: Middleware protects authenticated routes
✅ **Database Integration**: User profiles stored in Supabase

### 7. Account Types

**Individual**: Personal waste tracking and recycling
**Organization**: Business/organization waste management

The dashboard adapts its content based on the account type selected during signup.

## Next Steps

Once the basic authentication is working, you can:
- Add more profile fields
- Implement password reset functionality
- Add email verification (currently disabled for simplicity)
- Build out the recycling tracking features
- Add waste pickup scheduling functionality