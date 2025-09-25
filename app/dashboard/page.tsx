"use client"

import { useState, useEffect } from "react"
import { useRouter } from "next/navigation"
import Link from "next/link"
import { 
  BarChart,
  Bar,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  Legend,
  ResponsiveContainer,
  PieChart,
  Pie,
  Cell,
} from "recharts"
import { Calendar, Download, RefreshCw, User, Building, LogOut, Leaf } from "lucide-react"
import { getCurrentUser, signOutUser, getUserProfile } from "../../lib/auth"
import { supabase } from "../../lib/supabaseClient"

// Sample data - in a real app, this would come from your backend
const monthlyData = [
  { name: "Jan", recycled: 65, landfill: 35 },
  { name: "Feb", recycled: 59, landfill: 41 },
  { name: "Mar", recycled: 80, landfill: 20 },
  { name: "Apr", recycled: 81, landfill: 19 },
  { name: "May", recycled: 56, landfill: 44 },
  { name: "Jun", recycled: 55, landfill: 45 },
  { name: "Jul", recycled: 40, landfill: 60 },
  { name: "Aug", recycled: 70, landfill: 30 },
  { name: "Sep", recycled: 90, landfill: 10 },
  { name: "Oct", recycled: 85, landfill: 15 },
  { name: "Nov", recycled: 75, landfill: 25 },
  { name: "Dec", recycled: 62, landfill: 38 },
]

const wasteTypeData = [
  { name: "Paper", value: 35 },
  { name: "Plastic", value: 25 },
  { name: "Glass", value: 15 },
  { name: "Metal", value: 10 },
  { name: "Organic", value: 15 },
]

const COLORS = ["#0088FE", "#00C49F", "#FFBB28", "#FF8042", "#8884d8"]

export default function DashboardPage() {
  const [user, setUser] = useState<any>(null)
  const [userProfile, setUserProfile] = useState<any>(null)
  const [loading, setLoading] = useState(true)
  const [timeframe, setTimeframe] = useState("year")
  const router = useRouter()

  useEffect(() => {
    checkUser()
  }, [])

  const checkUser = async () => {
    try {
      console.log('Checking user authentication...')
      
      const currentUser = await getCurrentUser()
      if (!currentUser) {
        console.log('No authenticated user found, redirecting to login')
        router.push('/login')
        return
      }

      console.log('User authenticated:', currentUser.id)
      setUser(currentUser)

      // Fetch user profile from database
      const profile = await getUserProfile(currentUser.id)
      
      if (!profile) {
        console.error('No user profile found in database')
        // If no profile exists, redirect to signup to complete profile
        router.push('/signup?error=Profile not found. Please complete registration.')
        return
      }

      console.log('User profile loaded:', profile)
      setUserProfile(profile)
      
    } catch (error) {
      console.error('Error checking user:', error)
      router.push('/login?error=Authentication failed. Please sign in again.')
    } finally {
      setLoading(false)
    }
  }

  const handleLogout = async () => {
    try {
      console.log('Logging out user...')
      await signOutUser()
      router.push('/?message=Successfully logged out')
    } catch (error) {
      console.error('Logout error:', error)
      // Even if logout fails, redirect to home
      router.push('/')
    }
  }

  if (loading) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-gray-50">
        <div className="text-center">
          <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-green-500 mx-auto"></div>
          <p className="mt-4 text-gray-600">Loading dashboard...</p>
        </div>
      </div>
    )
  }

  if (!user || !userProfile) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-gray-50">
        <div className="text-center">
          <p className="text-gray-600 mb-4">Unable to load user data</p>
          <div className="space-y-2">
            <Link href="/login" className="text-green-600 hover:text-green-500 block">
              Return to Login
            </Link>
            <Link href="/signup" className="text-blue-600 hover:text-blue-500 block">
              Create Account
            </Link>
          </div>
        </div>
      </div>
    )
  }

  // Calculate totals
  const totalRecycled = monthlyData.reduce((sum, item) => sum + item.recycled, 0)
  const totalWaste = monthlyData.reduce((sum, item) => sum + item.recycled + item.landfill, 0)
  const recyclingRate = Math.round((totalRecycled / totalWaste) * 100)

  // Environmental impact calculations (simplified estimates)
  const treesSaved = Math.round(totalRecycled * 0.17)
  const co2Reduced = Math.round(totalRecycled * 2.5)
  const waterSaved = Math.round(totalRecycled * 7000)

  const isOrganization = userProfile.account_type === 'organization'

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Header */}
      <header className="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
          <div className="flex items-center justify-between">
            <div className="flex items-center gap-2">
              <Leaf className="w-8 h-8 text-green-500" />
              <h1 className="text-2xl font-bold text-gray-800">EcoWaste Dashboard</h1>
            </div>
            <div className="flex items-center gap-4">
              <div className="flex items-center gap-2 text-sm text-gray-600">
                {isOrganization ? (
                  <Building className="w-4 h-4" />
                ) : (
                  <User className="w-4 h-4" />
                )}
                <span>{userProfile.first_name} {userProfile.last_name}</span>
                <span className="text-gray-400">({isOrganization ? 'Organization' : 'Individual'})</span>
              </div>
              <button
                onClick={handleLogout}
                className="text-gray-600 hover:text-gray-800 font-medium transition-colors flex items-center gap-1"
              >
                <LogOut className="w-4 h-4" />
                Logout
              </button>
            </div>
          </div>
        </div>
      </header>

      <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {/* Welcome Message */}
        <div className="mb-8">
          <h2 className="text-3xl font-bold text-gray-800 mb-2">
            Welcome back, {userProfile.first_name}!
          </h2>
          <p className="text-gray-600">
            {isOrganization 
              ? "Track your organization's environmental impact and waste management progress."
              : "Track your personal environmental impact and recycling progress."
            }
          </p>
        </div>

        {/* Impact Summary Cards */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
          <div className="bg-white rounded-lg shadow-md p-6">
            <h3 className="text-lg font-medium text-gray-500 mb-2">Recycling Rate</h3>
            <div className="flex items-end space-x-2">
              <span className="text-3xl font-bold text-gray-800">{recyclingRate}%</span>
              <span className="text-sm text-green-500 pb-1">+5% from last year</span>
            </div>
            <div className="w-full bg-gray-200 rounded-full h-2.5 mt-4">
              <div 
                className="bg-green-500 h-2.5 rounded-full" 
                style={{ width: `${recyclingRate}%` }}
              ></div>
            </div>
          </div>

          <div className="bg-white rounded-lg shadow-md p-6">
            <h3 className="text-lg font-medium text-gray-500 mb-2">Trees Saved</h3>
            <div className="flex items-end space-x-2">
              <span className="text-3xl font-bold text-gray-800">{treesSaved}</span>
              <span className="text-sm text-gray-500 pb-1">trees</span>
            </div>
            <p className="text-sm text-gray-500 mt-4">Equivalent to planting a small forest</p>
          </div>

          <div className="bg-white rounded-lg shadow-md p-6">
            <h3 className="text-lg font-medium text-gray-500 mb-2">CO₂ Reduction</h3>
            <div className="flex items-end space-x-2">
              <span className="text-3xl font-bold text-gray-800">{co2Reduced}</span>
              <span className="text-sm text-gray-500 pb-1">tons</span>
            </div>
            <p className="text-sm text-gray-500 mt-4">Equivalent to taking 50 cars off the road</p>
          </div>

          <div className="bg-white rounded-lg shadow-md p-6">
            <h3 className="text-lg font-medium text-gray-500 mb-2">Water Saved</h3>
            <div className="flex items-end space-x-2">
              <span className="text-3xl font-bold text-gray-800">{waterSaved.toLocaleString()}</span>
              <span className="text-sm text-gray-500 pb-1">gallons</span>
            </div>
            <p className="text-sm text-gray-500 mt-4">Enough to fill 3 Olympic swimming pools</p>
          </div>
        </div>

        {/* Charts Section */}
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
          {/* Monthly Recycling Chart */}
          <div className="bg-white rounded-lg shadow-md p-6 lg:col-span-2">
            <div className="flex justify-between items-center mb-6">
              <h3 className="text-lg font-medium text-gray-800">Monthly Recycling Progress</h3>
              <div className="flex items-center space-x-2">
                <button
                  className={`px-3 py-1 text-sm rounded-md ${timeframe === "month" ? "bg-green-100 text-green-700" : "bg-gray-100 text-gray-600"}`}
                  onClick={() => setTimeframe("month")}
                >
                  Month
                </button>
                <button
                  className={`px-3 py-1 text-sm rounded-md ${timeframe === "quarter" ? "bg-green-100 text-green-700" : "bg-gray-100 text-gray-600"}`}
                  onClick={() => setTimeframe("quarter")}
                >
                  Quarter
                </button>
                <button
                  className={`px-3 py-1 text-sm rounded-md ${timeframe === "year" ? "bg-green-100 text-green-700" : "bg-gray-100 text-gray-600"}`}
                  onClick={() => setTimeframe("year")}
                >
                  Year
                </button>
              </div>
            </div>

            <div className="h-80">
              <ResponsiveContainer width="100%" height="100%">
                <BarChart data={monthlyData} margin={{ top: 5, right: 30, left: 20, bottom: 5 }}>
                  <CartesianGrid strokeDasharray="3 3" />
                  <XAxis dataKey="name" />
                  <YAxis />
                  <Tooltip />
                  <Legend />
                  <Bar dataKey="recycled" name="Recycled" fill="#4ade80" />
                  <Bar dataKey="landfill" name="Landfill" fill="#94a3b8" />
                </BarChart>
              </ResponsiveContainer>
            </div>
          </div>

          {/* Waste Composition Chart */}
          <div className="bg-white rounded-lg shadow-md p-6">
            <h3 className="text-lg font-medium text-gray-800 mb-6">Waste Composition</h3>
            <div className="h-80">
              <ResponsiveContainer width="100%" height="100%">
                <PieChart>
                  <Pie
                    data={wasteTypeData}
                    cx="50%"
                    cy="50%"
                    labelLine={false}
                    outerRadius={80}
                    fill="#8884d8"
                    dataKey="value"
                    label={({ name, percent }) => `${name} ${(percent * 100).toFixed(0)}%`}
                  >
                    {wasteTypeData.map((entry, index) => (
                      <Cell key={`cell-${index}`} fill={COLORS[index % COLORS.length]} />
                    ))}
                  </Pie>
                  <Tooltip />
                </PieChart>
              </ResponsiveContainer>
            </div>
          </div>
        </div>

        {/* Quick Actions */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
          <Link href="/schedule-pickup" className="group">
            <div className="bg-white p-6 rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-all group-hover:scale-105">
              <div className="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                <Calendar className="w-6 h-6 text-green-600" />
              </div>
              <h3 className="text-xl font-semibold text-gray-800 mb-2">Schedule Pickup</h3>
              <p className="text-gray-600">
                Schedule your next waste collection
              </p>
            </div>
          </Link>

          <Link href="/recycling-guide" className="group">
            <div className="bg-white p-6 rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-all group-hover:scale-105">
              <div className="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                <BarChart className="w-6 h-6 text-blue-600" />
              </div>
              <h3 className="text-xl font-semibold text-gray-800 mb-2">Recycling Guide</h3>
              <p className="text-gray-600">
                Learn proper recycling techniques
              </p>
            </div>
          </Link>

          <Link href="/profile" className="group">
            <div className="bg-white p-6 rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-all group-hover:scale-105">
              <div className="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                <User className="w-6 h-6 text-purple-600" />
              </div>
              <h3 className="text-xl font-semibold text-gray-800 mb-2">Profile Settings</h3>
              <p className="text-gray-600">
                Manage your account settings
              </p>
            </div>
          </Link>
        </div>
      </main>
    </div>
  )
}
