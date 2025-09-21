import { supabase } from './supabaseClient'

// Sign up user without email confirmation
export const signUpUser = async (email: string, password: string, userData: any) => {
  try {
    // Create user account
    const { data: authData, error: authError } = await supabase.auth.signUp({
      email,
      password,
      options: {
        // Completely disable email confirmation
        emailRedirectTo: undefined,
        // Auto-confirm the user
        data: {
          ...userData,
          email_confirmed: true,
        },
      },
    })

    if (authError) {
      throw authError
    }

    // If user was created successfully
    if (authData.user) {
      // Insert user data into our custom users table
      const { error: dbError } = await supabase.from("users").insert([
        {
          id: authData.user.id,
          email: email,
          first_name: userData.first_name,
          last_name: userData.last_name,
          account_type: userData.account_type,
          email_verified: true, // Mark as verified since we skip email confirmation
          is_active: true,
        },
      ])

      if (dbError) {
        console.error("Database error:", dbError)
        // Don't throw here as the auth account was created successfully
      }

      return { user: authData.user, session: authData.session }
    }

    return authData
  } catch (error) {
    console.error("Signup error:", error)
    throw error
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
      throw error
    }
    return user
  } catch (error) {
    console.error("Get user error:", error)
    return null
  }
}