"use client"

import { useState } from "react"
import Link from "next/link"
import { ArrowLeft, Recycle, AlertTriangle, CheckCircle, Info, Search } from "lucide-react"

export default function RecyclingGuidePage() {
  const [searchTerm, setSearchTerm] = useState("")
  const [selectedCategory, setSelectedCategory] = useState("all")

  const recyclingData = [
    {
      category: "paper",
      title: "Paper & Cardboard",
      items: [
        { name: "Newspapers", recyclable: true, notes: "Keep dry and clean" },
        { name: "Cardboard boxes", recyclable: true, notes: "Flatten and remove tape" },
        { name: "Office paper", recyclable: true, notes: "White and colored paper" },
        { name: "Magazines", recyclable: true, notes: "Glossy magazines are acceptable" },
        { name: "Waxed paper", recyclable: false, notes: "Not recyclable due to wax coating" },
        { name: "Pizza boxes", recyclable: false, notes: "Grease contamination makes it unrecyclable" }
      ]
    },
    {
      category: "plastic",
      title: "Plastic",
      items: [
        { name: "Water bottles (#1 PET)", recyclable: true, notes: "Remove caps and labels" },
        { name: "Milk jugs (#2 HDPE)", recyclable: true, notes: "Rinse thoroughly" },
        { name: "Plastic bags", recyclable: false, notes: "Take to special collection points" },
        { name: "Styrofoam", recyclable: false, notes: "Not accepted in curbside recycling" },
        { name: "Plastic utensils", recyclable: false, notes: "Too small for sorting machines" },
        { name: "Plastic containers (#1-7)", recyclable: true, notes: "Check local guidelines" }
      ]
    },
    {
      category: "glass",
      title: "Glass",
      items: [
        { name: "Glass bottles", recyclable: true, notes: "Remove caps and rinse" },
        { name: "Glass jars", recyclable: true, notes: "Labels can stay on" },
        { name: "Drinking glasses", recyclable: false, notes: "Different composition than bottles" },
        { name: "Ceramics", recyclable: false, notes: "Not glass - different melting point" },
        { name: "Light bulbs", recyclable: false, notes: "Take to special collection points" },
        { name: "Window glass", recyclable: false, notes: "Different type of glass" }
      ]
    },
    {
      category: "metal",
      title: "Metal",
      items: [
        { name: "Aluminum cans", recyclable: true, notes: "Rinse and crush if possible" },
        { name: "Steel cans", recyclable: true, notes: "Remove labels and rinse" },
        { name: "Tin cans", recyclable: true, notes: "Clean food residue" },
        { name: "Aerosol cans", recyclable: true, notes: "Must be completely empty" },
        { name: "Aluminum foil", recyclable: true, notes: "Clean and ball up" },
        { name: "Batteries", recyclable: false, notes: "Take to hazardous waste collection" }
      ]
    },
    {
      category: "organic",
      title: "Organic Waste",
      items: [
        { name: "Fruit peels", recyclable: true, notes: "Great for composting" },
        { name: "Vegetable scraps", recyclable: true, notes: "Compost or municipal collection" },
        { name: "Coffee grounds", recyclable: true, notes: "Excellent for composting" },
        { name: "Eggshells", recyclable: true, notes: "Crush before composting" },
        { name: "Meat scraps", recyclable: false, notes: "Can attract pests - use municipal collection" },
        { name: "Dairy products", recyclable: false, notes: "Not suitable for home composting" }
      ]
    }
  ]

  const tips = [
    {
      icon: <CheckCircle className="w-5 h-5 text-green-500" />,
      title: "Clean Before Recycling",
      description: "Always rinse containers to remove food residue. Dirty items can contaminate entire batches."
    },
    {
      icon: <AlertTriangle className="w-5 h-5 text-yellow-500" />,
      title: "Check Local Guidelines",
      description: "Recycling rules vary by location. Check with your local waste management for specific requirements."
    },
    {
      icon: <Info className="w-5 h-5 text-blue-500" />,
      title: "When in Doubt, Throw It Out",
      description: "If you're unsure whether something is recyclable, it's better to throw it away than contaminate the recycling stream."
    },
    {
      icon: <Recycle className="w-5 h-5 text-green-500" />,
      title: "Reduce and Reuse First",
      description: "Recycling is the third R. Focus on reducing waste and reusing items before recycling."
    }
  ]

  const filteredData = recyclingData.filter(category => 
    selectedCategory === "all" || category.category === selectedCategory
  ).map(category => ({
    ...category,
    items: category.items.filter(item =>
      item.name.toLowerCase().includes(searchTerm.toLowerCase())
    )
  })).filter(category => category.items.length > 0)

  return (
    <div className="min-h-screen bg-gray-50 py-12">
      <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Header */}
        <div className="mb-8">
          <Link 
            href="/dashboard" 
            className="inline-flex items-center text-green-600 hover:text-green-500 mb-4"
          >
            <ArrowLeft className="w-4 h-4 mr-2" />
            Back to Dashboard
          </Link>
          <h1 className="text-3xl font-bold text-gray-800 mb-2">Recycling Guide</h1>
          <p className="text-gray-600">Learn how to properly recycle different types of materials</p>
        </div>

        {/* Search and Filter */}
        <div className="bg-white rounded-lg shadow-md p-6 mb-8">
          <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div className="relative">
              <Search className="absolute left-3 top-3 w-4 h-4 text-gray-400" />
              <input
                type="text"
                placeholder="Search for specific items..."
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
                className="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500"
              />
            </div>
            <select
              value={selectedCategory}
              onChange={(e) => setSelectedCategory(e.target.value)}
              aria-label="Filter by category"
              className="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500"
            >
              <option value="all">All Categories</option>
              <option value="paper">Paper & Cardboard</option>
              <option value="plastic">Plastic</option>
              <option value="glass">Glass</option>
              <option value="metal">Metal</option>
              <option value="organic">Organic Waste</option>
            </select>
          </div>
        </div>

        {/* Recycling Categories */}
        <div className="space-y-8">
          {filteredData.map((category) => (
            <div key={category.category} className="bg-white rounded-lg shadow-md overflow-hidden">
              <div className="bg-green-50 px-6 py-4 border-b border-gray-200">
                <h2 className="text-xl font-semibold text-gray-800 flex items-center gap-2">
                  <Recycle className="w-5 h-5 text-green-600" />
                  {category.title}
                </h2>
              </div>
              <div className="p-6">
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                  {category.items.map((item, index) => (
                    <div key={index} className="flex items-start gap-3 p-4 border border-gray-200 rounded-lg">
                      <div className="flex-shrink-0 mt-1">
                        {item.recyclable ? (
                          <CheckCircle className="w-5 h-5 text-green-500" />
                        ) : (
                          <AlertTriangle className="w-5 h-5 text-red-500" />
                        )}
                      </div>
                      <div className="flex-1">
                        <h3 className="font-medium text-gray-800">{item.name}</h3>
                        <p className={`text-sm ${item.recyclable ? 'text-green-600' : 'text-red-600'} font-medium mb-1`}>
                          {item.recyclable ? 'Recyclable' : 'Not Recyclable'}
                        </p>
                        <p className="text-sm text-gray-600">{item.notes}</p>
                      </div>
                    </div>
                  ))}
                </div>
              </div>
            </div>
          ))}
        </div>

        {/* Recycling Tips */}
        <div className="mt-12">
          <h2 className="text-2xl font-bold text-gray-800 mb-6">Recycling Best Practices</h2>
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            {tips.map((tip, index) => (
              <div key={index} className="bg-white rounded-lg shadow-md p-6">
                <div className="flex items-start gap-4">
                  <div className="flex-shrink-0">
                    {tip.icon}
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-800 mb-2">{tip.title}</h3>
                    <p className="text-gray-600">{tip.description}</p>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>

        {/* Environmental Impact */}
        <div className="mt-12 bg-green-50 rounded-lg p-8">
          <h2 className="text-2xl font-bold text-gray-800 mb-4">Why Recycling Matters</h2>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div className="text-center">
              <div className="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <Recycle className="w-6 h-6 text-green-600" />
              </div>
              <h3 className="font-semibold text-gray-800 mb-2">Reduces Landfill Waste</h3>
              <p className="text-gray-600 text-sm">Proper recycling keeps materials out of landfills and extends their useful life.</p>
            </div>
            <div className="text-center">
              <div className="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <CheckCircle className="w-6 h-6 text-blue-600" />
              </div>
              <h3 className="font-semibold text-gray-800 mb-2">Conserves Resources</h3>
              <p className="text-gray-600 text-sm">Recycling reduces the need for raw materials and energy in manufacturing.</p>
            </div>
            <div className="text-center">
              <div className="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <Info className="w-6 h-6 text-purple-600" />
              </div>
              <h3 className="font-semibold text-gray-800 mb-2">Fights Climate Change</h3>
              <p className="text-gray-600 text-sm">Recycling reduces greenhouse gas emissions compared to producing new materials.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  )
}
