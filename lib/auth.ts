import { supabase } from './supabaseClient'

// Sign up user without email confirmation
export const signUpUser = async (email: string, password: string, userData: any) => {
  try {
    console.log('Starting user registration...', { email, userData })
    
    // Create user account with Supabase Auth
    const { data: authData, error: authError } = await supabase.auth.signUp({
      email,
      password,
      options: {
        // Disable email confirmation for now
        emailRedirectTo: undefined,
        data: {
          first_name: userData.first_name,
          last_name: userData.last_name,
          account_type: userData.account_type || 'individual',
        },
      },
    })

    if (authError) {
      console.error('Auth signup error:', authError)
      throw new Error(authError.message || 'Failed to create account')
    }

    if (!authData.user) {
      throw new Error('User creation failed - no user returned')
    }

    console.log('Auth user created:', authData.user.id)

    // Wait a moment for auth to settle
    await new Promise(resolve => setTimeout(resolve, 1000))

    // Insert user data into our custom users table
    const { error: dbError } = await supabase.from('users').insert({
      id: authData.user.id,
      email: email,
      first_name: userData.first_name,
      last_name: userData.last_name,
      account_type: userData.account_type || 'individual',
      email_verified: true, // Mark as verified since we're skipping email confirmation
      is_active: true,
    })

    if (dbError) {
      console.error('Database insert error:', dbError)
      // If we can't insert into our users table, we should clean up the auth user
      await supabase.auth.admin.deleteUser(authData.user.id)
      throw new Error('Failed to create user profile. Please try again.')
    }

    console.log('User profile created successfully')
    return { user: authData.user, session: authData.session }
    
  } catch (error: any) {
    console.error('Complete signup error:', error)
    throw new Error(error.message || 'Registration failed. Please try again.')
  }
}

// Sign in user
export const signInUser = async (email: string, password: string) => {
  try {
    const { data, error } = await supabase.auth.signInWithPassword({
      email,
      password,
    })

    if (error) {
      throw error
    }

    return data
  } catch (error) {
    console.error("Login error:", error)
    throw error
  }
}

// Sign out user
export const signOutUser = async () => {
  try {
    const { error } = await supabase.auth.signOut()
    if (error) {
      throw error
    }
  } catch (error) {
    console.error("Logout error:", error)
    throw error
  }
}

// Get current user
export const getCurrentUser = async () => {
  try {
    const { data: { user }, error } = await supabase.auth.getUser()
    if (error) {
      console.error('Get user error:', error)
      return null
    }
    return user
  } catch (error) {
    console.error('Get user error:', error)
    return null
  }
}

// Get current user session
export const getCurrentSession = async () => {
  try {
    const { data: { session }, error } = await supabase.auth.getSession()
    if (error) {
      console.error('Get session error:', error)
      return null
    }
    return session
  } catch (error) {
    console.error('Get session error:', error)
    return null
  }
}

// Get user profile from database
export const getUserProfile = async (userId: string) => {
  try {
    const { data, error } = await supabase
      .from('users')
      .select('*')
      .eq('id', userId)
      .single()

    if (error) {
      console.error('Get profile error:', error)
      return null
    }
    
    return data
  } catch (error) {
    console.error('Get profile error:', error)
    return null
  }
}