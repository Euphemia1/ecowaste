"use client"

import { useState } from "react"
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
import { Calendar, Download, RefreshCw } from "lucide-react"

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

export default function ImpactDashboardPage() {
  const [timeframe, setTimeframe] = useState("year")

  // Calculate totals
  const totalRecycled = monthlyData.reduce((sum, item) => sum + item.recycled, 0)
  const totalWaste = monthlyData.reduce((sum, item) => sum + item.recycled + item.landfill, 0)
  const recyclingRate = Math.round((totalRecycled / totalWaste) * 100)

  // Environmental impact calculations (simplified estimates)
  const treesSaved = Math.round(totalRecycled * 0.17) // Approx. 17 trees saved per ton of recycled paper
  const co2Reduced = Math.round(totalRecycled * 2.5) // Approx. 2.5 tons of CO2 reduced per ton of recycled waste
  const waterSaved = Math.round(totalRecycled * 7000) // Approx. 7000 gallons of water saved per ton of recycled waste

  return (
    <main className="min-h-screen py-12 bg-gray-50">
      <div className="container mx-auto px-4 md:px-6">
        <div className="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
          <div>
            <h1 className="text-3xl md:text-4xl font-bold text-gray-800">Impact Dashboard</h1>
            <p className="text-gray-600 mt-2">Track your environmental impact and recycling progress</p>
          </div>

          <div className="flex space-x-2 mt-4 md:mt-0">
            <button className="flex items-center space-x-1 bg-white border border-gray-300 rounded-md px-3 py-2 text-sm text-gray-600 hover:bg-gray-50">
              <Calendar className="h-4 w-4" />
              <span>This Year</span>
            </button>
            <button className="flex items-center space-x-1 bg-white border border-gray-300 rounded-md px-3 py-2 text-sm text-gray-600 hover:bg-gray-50">
              <Download className="h-4 w-4" />
              <span>Export</span>
            </button>
            <button className="flex items-center space-x-1 bg-white border border-gray-300 rounded-md px-3 py-2 text-sm text-gray-600 hover:bg-gray-50">
              <RefreshCw className="h-4 w-4" />
              <span>Refresh</span>
            </button>
          </div>
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
              <div className="bg-green-500 h-2.5 rounded-full" style={{ width: `${recyclingRate}%` }}></div>
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
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
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

        {/* Tips Section */}
        <div className="bg-green-50 rounded-lg p-6 mt-8">
          <h3 className="text-lg font-medium text-gray-800 mb-4">Tips to Improve Your Impact</h3>
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div className="bg-white p-4 rounded-md shadow-sm">
              <h4 className="font-medium text-gray-800 mb-2">Reduce Plastic Usage</h4>
              <p className="text-sm text-gray-600">
                Switch to reusable water bottles and shopping bags to reduce plastic waste.
              </p>
            </div>
            <div className="bg-white p-4 rounded-md shadow-sm">
              <h4 className="font-medium text-gray-800 mb-2">Compost Food Scraps</h4>
              <p className="text-sm text-gray-600">
                Start composting food scraps to divert organic waste from landfills.
              </p>
            </div>
            <div className="bg-white p-4 rounded-md shadow-sm">
              <h4 className="font-medium text-gray-800 mb-2">Proper Recycling</h4>
              <p className="text-sm text-gray-600">
                Make sure to clean containers before recycling to avoid contamination.
              </p>
            </div>
          </div>
        </div>
      </div>
    </main>
  )
}
