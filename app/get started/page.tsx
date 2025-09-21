"use client"

import type React from "react"

import { useState, useEffect } from "react"
import Link from "next/link"
import { Eye, EyeOff, Leaf, CheckCircle } from "lucide-react"
import { signUpUser } from "../../lib/auth"
import { useRouter } from "next/navigation"

export default function GetStartedPage() {
  const [step, setStep] = useState(1)
  const [formData, setFormData] = useState({
    firstName: "",
    lastName: "",
    email: "",
    password: "",
    confirmPassword: "",
    accountType: "individual",
    agreeTerms: false,
  })
  const [showPassword, setShowPassword] = useState(false)
  const [showConfirmPassword, setShowConfirmPassword] = useState(false)
  const [loading, setLoading] = useState(false)
  const [error, setError] = useState("")
  const router = useRouter()

  // Auto redirect to login after successful registration
  useEffect(() => {
    if (step === 2) {
      const timer = setTimeout(() => {
        router.push('/login')
      }, 3000) // Redirect after 3 seconds

      return () => clearTimeout(timer)
    }
  }, [step, router])

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value, type, checked } = e.target
    setFormData((prev) => ({
      ...prev,
      [name]: type === "checkbox" ? checked : value,
    }))
  }

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault()
    setLoading(true)
    setError("")

    // Validate passwords match
    if (formData.password !== formData.confirmPassword) {
      setError("Passwords do not match")
      setLoading(false)
      return
    }

    // Validate password strength
    if (formData.password.length < 8) {
      setError("Password must be at least 8 characters long")
      setLoading(false)
      return
    }

    try {
      console.log("Starting registration process...")
      
      // Create user account without email confirmation
      const result = await signUpUser(formData.email, formData.password, {
        first_name: formData.firstName,
        last_name: formData.lastName,
        account_type: formData.accountType,
      })

      console.log("Registration successful:", result)
      
      // Make sure we move to step 2 (success page)
      setStep(2)
      console.log("Set step to 2 - showing success page")
      
    } catch (error: any) {
      console.error("Registration error:", error)
      setError(error.message || "Registration failed. Please try again.")
    } finally {
      setLoading(false)
    }
  }

  return (
    <main className="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
      <div className="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-md">
        {/* Debug info - remove this later */}
        <div className="text-xs text-gray-500 text-center">Current step: {step}</div>
        
        {step === 1 ? (
          <>
            <div className="text-center">
              <div className="flex justify-center">
                <Leaf className="h-12 w-12 text-green-500" />
              </div>
              <h2 className="mt-6 text-3xl font-bold text-gray-800">Get Started</h2>
              <p className="mt-2 text-sm text-gray-600">Create your EcoWaste account and start making a difference</p>
            </div>

            <form className="mt-8 space-y-6" onSubmit={handleSubmit}>
              {error && (
                <div className="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md">
                  {error}
                </div>
              )}
              
              <div className="space-y-4">
                <div className="grid grid-cols-2 gap-4">
                  <div>
                    <label htmlFor="firstName" className="block text-sm font-medium text-gray-700 mb-1">
                      First Name
                    </label>
                    <input
                      id="firstName"
                      name="firstName"
                      type="text"
                      required
                      value={formData.firstName}
                      onChange={handleChange}
                      className="appearance-none relative block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500"
                    />
                  </div>
                  <div>
                    <label htmlFor="lastName" className="block text-sm font-medium text-gray-700 mb-1">
                      Last Name
                    </label>
                    <input
                      id="lastName"
                      name="lastName"
                      type="text"
                      required
                      value={formData.lastName}
                      onChange={handleChange}
                      className="appearance-none relative block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500"
                    />
                  </div>
                </div>

                <div>
                  <label htmlFor="email" className="block text-sm font-medium text-gray-700 mb-1">
                    Email address
                  </label>
                  <input
                    id="email"
                    name="email"
                    type="email"
                    autoComplete="email"
                    required
                    value={formData.email}
                    onChange={handleChange}
                    className="appearance-none relative block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500"
                  />
                </div>

                <div>
                  <label htmlFor="password" className="block text-sm font-medium text-gray-700 mb-1">
                    Password
                  </label>
                  <div className="relative">
                    <input
                      id="password"
                      name="password"
                      type={showPassword ? "text" : "password"}
                      required
                      value={formData.password}
                      onChange={handleChange}
                      className="appearance-none relative block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500"
                    />
                    <button
                      type="button"
                      className="absolute inset-y-0 right-0 pr-3 flex items-center"
                      onClick={() => setShowPassword(!showPassword)}
                    >
                      {showPassword ? (
                        <EyeOff className="h-5 w-5 text-gray-400" />
                      ) : (
                        <Eye className="h-5 w-5 text-gray-400" />
                      )}
                    </button>
                  </div>
                  <p className="mt-1 text-xs text-gray-500">
                    Password must be at least 8 characters long with a mix of letters, numbers, and symbols.
                  </p>
                </div>

                <div>
                  <label htmlFor="confirmPassword" className="block text-sm font-medium text-gray-700 mb-1">
                    Confirm Password
                  </label>
                  <div className="relative">
                    <input
                      id="confirmPassword"
                      name="confirmPassword"
                      type={showConfirmPassword ? "text" : "password"}
                      required
                      value={formData.confirmPassword}
                      onChange={handleChange}
                      className="appearance-none relative block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500"
                    />
                    <button
                      type="button"
                      className="absolute inset-y-0 right-0 pr-3 flex items-center"
                      onClick={() => setShowConfirmPassword(!showConfirmPassword)}
                    >
                      {showConfirmPassword ? (
                        <EyeOff className="h-5 w-5 text-gray-400" />
                      ) : (
                        <Eye className="h-5 w-5 text-gray-400" />
                      )}
                    </button>
                  </div>
                </div>

                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">Account Type</label>
                  <div className="flex space-x-4">
                    <div className="flex items-center">
                      <input
                        id="individual"
                        name="accountType"
                        type="radio"
                        value="individual"
                        checked={formData.accountType === "individual"}
                        onChange={handleChange}
                        className="h-4 w-4 text-green-500 focus:ring-green-400 border-gray-300"
                      />
                      <label htmlFor="individual" className="ml-2 block text-sm text-gray-700">
                        Individual
                      </label>
                    </div>
                    <div className="flex items-center">
                      <input
                        id="business"
                        name="accountType"
                        type="radio"
                        value="business"
                        checked={formData.accountType === "business"}
                        onChange={handleChange}
                        className="h-4 w-4 text-green-500 focus:ring-green-400 border-gray-300"
                      />
                      <label htmlFor="business" className="ml-2 block text-sm text-gray-700">
                        Business
                      </label>
                    </div>
                  </div>
                </div>

                <div className="flex items-center">
                  <input
                    id="agreeTerms"
                    name="agreeTerms"
                    type="checkbox"
                    required
                    checked={formData.agreeTerms}
                    onChange={handleChange}
                    className="h-4 w-4 text-green-500 focus:ring-green-400 border-gray-300 rounded"
                  />
                  <label htmlFor="agreeTerms" className="ml-2 block text-sm text-gray-700">
                    I agree to the{" "}
                    <Link href="/terms" className="text-green-600 hover:text-green-500">
                      Terms of Service
                    </Link>{" "}
                    and{" "}
                    <Link href="/privacy" className="text-green-600 hover:text-green-500">
                      Privacy Policy
                    </Link>
                  </label>
                </div>
              </div>

              <div>
                <button
                  type="submit"
                  disabled={loading}
                  className="group relative w-full flex justify-center py-2 px-4 border border-transparent rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  {loading ? "Creating Account..." : "Create Account"}
                </button>
              </div>

              <div className="text-center mt-4">
                <p className="text-sm text-gray-600">
                  Already have an account?{" "}
                  <Link href="/login" className="text-green-600 hover:text-green-500 font-medium">
                    Sign in
                  </Link>
                </p>
              </div>
            </form>
          </>
        ) : (
          <div className="text-center py-8">
            <div className="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-6">
              <CheckCircle className="h-8 w-8 text-green-500" />
            </div>
            <h2 className="text-2xl font-bold text-gray-800 mb-2">Account Created Successfully!</h2>
            <p className="text-gray-600 mb-6">
              Welcome to EcoWaste! Your account has been created with email: {formData.email}
            </p>
            <p className="text-gray-600 mb-8">Redirecting to login page in 3 seconds...</p>
            <Link
              href="/login"
              className="inline-flex justify-center py-2 px-4 border border-transparent rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
            >
              Go to Login Now
            </Link>
          </div>
        )}
      </div>
    </main>
  )
}
