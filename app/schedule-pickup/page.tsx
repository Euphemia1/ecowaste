"use client"

import { useState } from "react"
import Link from "next/link"
import { ArrowLeft, Calendar, MapPin, Clock, Recycle, CheckCircle } from "lucide-react"

export default function SchedulePickupPage() {
  const [step, setStep] = useState(1)
  const [formData, setFormData] = useState({
    wasteType: "",
    quantity: "",
    location: "",
    preferredDate: "",
    preferredTime: "",
    specialInstructions: "",
    contactPhone: "",
  })

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
    const { name, value } = e.target
    setFormData(prev => ({
      ...prev,
      [name]: value
    }))
  }

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault()
    setStep(2)
  }

  const wasteTypes = [
    "Paper & Cardboard",
    "Plastic",
    "Glass",
    "Metal",
    "Organic Waste",
    "Electronic Waste",
    "Mixed Recycling"
  ]

  const timeSlots = [
    "9:00 AM - 12:00 PM",
    "12:00 PM - 3:00 PM", 
    "3:00 PM - 6:00 PM"
  ]

  return (
    <div className="min-h-screen bg-gray-50 py-12">
      <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Header */}
        <div className="mb-8">
          <Link 
            href="/dashboard" 
            className="inline-flex items-center text-green-600 hover:text-green-500 mb-4"
          >
            <ArrowLeft className="w-4 h-4 mr-2" />
            Back to Dashboard
          </Link>
          <h1 className="text-3xl font-bold text-gray-800">Schedule Waste Pickup</h1>
          <p className="text-gray-600 mt-2">Book a convenient time for eco-friendly waste collection</p>
        </div>

        {/* Progress Steps */}
        <div className="mb-8">
          <div className="flex items-center justify-center">
            <div className="flex items-center">
              <div className={`w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium ${
                step >= 1 ? 'bg-green-600 text-white' : 'bg-gray-300 text-gray-600'
              }`}>
                1
              </div>
              <div className={`w-16 h-1 mx-2 ${step >= 2 ? 'bg-green-600' : 'bg-gray-300'}`}></div>
              <div className={`w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium ${
                step >= 2 ? 'bg-green-600 text-white' : 'bg-gray-300 text-gray-600'
              }`}>
                2
              </div>
            </div>
          </div>
          <div className="flex justify-center mt-4">
            <span className="text-sm text-gray-600">
              {step === 1 ? 'Waste Details' : 'Confirmation'}
            </span>
          </div>
        </div>

        {step === 1 ? (
          <form onSubmit={handleSubmit} className="bg-white rounded-lg shadow-md p-8">
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
              {/* Waste Type */}
              <div className="md:col-span-2">
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Type of Waste
                </label>
                <select
                  name="wasteType"
                  value={formData.wasteType}
                  onChange={handleChange}
                  required
                  aria-label="Type of waste"
                  className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500"
                >
                  <option value="">Select waste type</option>
                  {wasteTypes.map(type => (
                    <option key={type} value={type}>{type}</option>
                  ))}
                </select>
              </div>

              {/* Quantity */}
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Estimated Quantity
                </label>
                <select
                  name="quantity"
                  value={formData.quantity}
                  onChange={handleChange}
                  required
                  aria-label="Estimated quantity"
                  className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500"
                >
                  <option value="">Select quantity</option>
                  <option value="small">Small (1-2 bags)</option>
                  <option value="medium">Medium (3-5 bags)</option>
                  <option value="large">Large (6+ bags)</option>
                  <option value="bulk">Bulk items</option>
                </select>
              </div>

              {/* Location */}
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Pickup Location
                </label>
                <div className="relative">
                  <MapPin className="absolute left-3 top-3 w-4 h-4 text-gray-400" />
                  <input
                    type="text"
                    name="location"
                    value={formData.location}
                    onChange={handleChange}
                    required
                    placeholder="Enter your address"
                    className="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500"
                  />
                </div>
              </div>

              {/* Preferred Date */}
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Preferred Date
                </label>
                <div className="relative">
                  <Calendar className="absolute left-3 top-3 w-4 h-4 text-gray-400" />
                  <input
                    type="date"
                    name="preferredDate"
                    value={formData.preferredDate}
                    onChange={handleChange}
                    required
                    min={new Date().toISOString().split('T')[0]}
                    aria-label="Preferred pickup date"
                    className="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500"
                  />
                </div>
              </div>

              {/* Preferred Time */}
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Preferred Time
                </label>
                <select
                  name="preferredTime"
                  value={formData.preferredTime}
                  onChange={handleChange}
                  required
                  aria-label="Preferred time slot"
                  className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500"
                >
                  <option value="">Select time slot</option>
                  {timeSlots.map(time => (
                    <option key={time} value={time}>{time}</option>
                  ))}
                </select>
              </div>

              {/* Contact Phone */}
              <div className="md:col-span-2">
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Contact Phone Number
                </label>
                <input
                  type="tel"
                  name="contactPhone"
                  value={formData.contactPhone}
                  onChange={handleChange}
                  required
                  placeholder="Enter your phone number"
                  className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500"
                />
              </div>

              {/* Special Instructions */}
              <div className="md:col-span-2">
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Special Instructions (Optional)
                </label>
                <textarea
                  name="specialInstructions"
                  value={formData.specialInstructions}
                  onChange={handleChange}
                  rows={3}
                  placeholder="Any special instructions for the pickup team..."
                  className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500"
                />
              </div>
            </div>

            <div className="mt-8 flex justify-end">
              <button
                type="submit"
                className="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md font-medium transition-colors flex items-center gap-2"
              >
                Continue
                <ArrowLeft className="w-4 h-4 rotate-180" />
              </button>
            </div>
          </form>
        ) : (
          <div className="bg-white rounded-lg shadow-md p-8 text-center">
            <div className="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-6">
              <CheckCircle className="h-8 w-8 text-green-500" />
            </div>
            <h2 className="text-2xl font-bold text-gray-800 mb-4">Pickup Scheduled Successfully!</h2>
            <p className="text-gray-600 mb-6">
              Your waste pickup has been scheduled for <strong>{formData.preferredDate}</strong> at <strong>{formData.preferredTime}</strong>
            </p>
            <div className="bg-gray-50 rounded-lg p-4 mb-6 text-left">
              <h3 className="font-medium text-gray-800 mb-2">Pickup Details:</h3>
              <ul className="space-y-1 text-sm text-gray-600">
                <li><strong>Type:</strong> {formData.wasteType}</li>
                <li><strong>Quantity:</strong> {formData.quantity}</li>
                <li><strong>Location:</strong> {formData.location}</li>
                <li><strong>Date:</strong> {formData.preferredDate}</li>
                <li><strong>Time:</strong> {formData.preferredTime}</li>
                <li><strong>Contact:</strong> {formData.contactPhone}</li>
              </ul>
            </div>
            <div className="flex flex-col sm:flex-row gap-4 justify-center">
              <Link
                href="/dashboard"
                className="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md font-medium transition-colors"
              >
                Back to Dashboard
              </Link>
              <Link
                href="/schedule-pickup"
                className="border border-gray-300 text-gray-700 hover:bg-gray-50 px-6 py-2 rounded-md font-medium transition-colors"
              >
                Schedule Another Pickup
              </Link>
            </div>
          </div>
        )}
      </div>
    </div>
  )
}
