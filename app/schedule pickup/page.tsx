"use client"

import type React from "react"

import { useState } from "react"
import { Calendar, Clock, MapPin, Truck, CheckCircle } from "lucide-react"

export default function SchedulePickupPage() {
  const [step, setStep] = useState(1)
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    phone: "",
    address: "",
    city: "",
    zipCode: "",
    date: "",
    time: "",
    wasteType: [],
    notes: "",
  })

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
    const { name, value } = e.target
    setFormData((prev) => ({ ...prev, [name]: value }))
  }

  const handleCheckboxChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { value, checked } = e.target
    setFormData((prev) => ({
      ...prev,
      wasteType: checked ? [...prev.wasteType, value] : prev.wasteType.filter((type) => type !== value),
    }))
  }

  const nextStep = () => {
    setStep((prev) => prev + 1)
  }

  const prevStep = () => {
    setStep((prev) => prev - 1)
  }

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault()
    // In a real app, you would submit the form data to your backend here
    console.log("Form submitted:", formData)
    nextStep()
  }

  return (
    <main className="min-h-screen py-12 bg-gray-50">
      <div className="container mx-auto px-4 md:px-6">
        <div className="max-w-3xl mx-auto">
          <h1 className="text-3xl md:text-4xl font-bold text-center mb-4">Schedule a Pickup</h1>
          <p className="text-lg text-gray-600 text-center mb-8">
            Let us handle your waste collection in an eco-friendly way
          </p>

          {/* Progress Steps */}
          <div className="flex justify-between items-center mb-8">
            <div className={`flex flex-col items-center ${step >= 1 ? "text-green-500" : "text-gray-400"}`}>
              <div
                className={`w-10 h-10 rounded-full flex items-center justify-center mb-2 ${step >= 1 ? "bg-green-100" : "bg-gray-100"}`}
              >
                <MapPin className="h-5 w-5" />
              </div>
              <span className="text-sm">Location</span>
            </div>
            <div className="flex-1 h-1 mx-2 bg-gray-200">
              <div
                className={`h-full ${step >= 2 ? "bg-green-500" : "bg-gray-200"}`}
                style={{ width: step >= 2 ? "100%" : "0%" }}
              ></div>
            </div>
            <div className={`flex flex-col items-center ${step >= 2 ? "text-green-500" : "text-gray-400"}`}>
              <div
                className={`w-10 h-10 rounded-full flex items-center justify-center mb-2 ${step >= 2 ? "bg-green-100" : "bg-gray-100"}`}
              >
                <Calendar className="h-5 w-5" />
              </div>
              <span className="text-sm">Schedule</span>
            </div>
            <div className="flex-1 h-1 mx-2 bg-gray-200">
              <div
                className={`h-full ${step >= 3 ? "bg-green-500" : "bg-gray-200"}`}
                style={{ width: step >= 3 ? "100%" : "0%" }}
              ></div>
            </div>
            <div className={`flex flex-col items-center ${step >= 3 ? "text-green-500" : "text-gray-400"}`}>
              <div
                className={`w-10 h-10 rounded-full flex items-center justify-center mb-2 ${step >= 3 ? "bg-green-100" : "bg-gray-100"}`}
              >
                <Truck className="h-5 w-5" />
              </div>
              <span className="text-sm">Details</span>
            </div>
            <div className="flex-1 h-1 mx-2 bg-gray-200">
              <div
                className={`h-full ${step >= 4 ? "bg-green-500" : "bg-gray-200"}`}
                style={{ width: step >= 4 ? "100%" : "0%" }}
              ></div>
            </div>
            <div className={`flex flex-col items-center ${step >= 4 ? "text-green-500" : "text-gray-400"}`}>
              <div
                className={`w-10 h-10 rounded-full flex items-center justify-center mb-2 ${step >= 4 ? "bg-green-100" : "bg-gray-100"}`}
              >
                <CheckCircle className="h-5 w-5" />
              </div>
              <span className="text-sm">Confirmation</span>
            </div>
          </div>

          {/* Form Steps */}
          <div className="bg-white rounded-lg shadow-md p-6">
            {step === 1 && (
              <div>
                <h2 className="text-xl font-semibold mb-4">Location Information</h2>
                <div className="space-y-4">
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                      <label htmlFor="name" className="block text-sm font-medium text-gray-700 mb-1">
                        Full Name
                      </label>
                      <input
                        type="text"
                        id="name"
                        name="name"
                        value={formData.name}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                        required
                      />
                    </div>
                    <div>
                      <label htmlFor="email" className="block text-sm font-medium text-gray-700 mb-1">
                        Email Address
                      </label>
                      <input
                        type="email"
                        id="email"
                        name="email"
                        value={formData.email}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                        required
                      />
                    </div>
                  </div>
                  <div>
                    <label htmlFor="phone" className="block text-sm font-medium text-gray-700 mb-1">
                      Phone Number
                    </label>
                    <input
                      type="tel"
                      id="phone"
                      name="phone"
                      value={formData.phone}
                      onChange={handleChange}
                      className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                      required
                    />
                  </div>
                  <div>
                    <label htmlFor="address" className="block text-sm font-medium text-gray-700 mb-1">
                      Street Address
                    </label>
                    <input
                      type="text"
                      id="address"
                      name="address"
                      value={formData.address}
                      onChange={handleChange}
                      className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                      required
                    />
                  </div>
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                      <label htmlFor="city" className="block text-sm font-medium text-gray-700 mb-1">
                        City
                      </label>
                      <input
                        type="text"
                        id="city"
                        name="city"
                        value={formData.city}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                        required
                      />
                    </div>
                    <div>
                      <label htmlFor="zipCode" className="block text-sm font-medium text-gray-700 mb-1">
                        ZIP Code
                      </label>
                      <input
                        type="text"
                        id="zipCode"
                        name="zipCode"
                        value={formData.zipCode}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                        required
                      />
                    </div>
                  </div>
                </div>
                <div className="mt-6 flex justify-end">
                  <button
                    type="button"
                    onClick={nextStep}
                    className="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-md transition-colors"
                  >
                    Next Step
                  </button>
                </div>
              </div>
            )}

            {step === 2 && (
              <div>
                <h2 className="text-xl font-semibold mb-4">Schedule Pickup</h2>
                <div className="space-y-4">
                  <div>
                    <label htmlFor="date" className="block text-sm font-medium text-gray-700 mb-1">
                      Pickup Date
                    </label>
                    <input
                      type="date"
                      id="date"
                      name="date"
                      value={formData.date}
                      onChange={handleChange}
                      className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                      required
                    />
                  </div>
                  <div>
                    <label htmlFor="time" className="block text-sm font-medium text-gray-700 mb-1">
                      Preferred Time
                    </label>
                    <select
                      id="time"
                      name="time"
                      value={formData.time}
                      onChange={handleChange}
                      className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                      required
                    >
                      <option value="">Select a time slot</option>
                      <option value="morning">Morning (8:00 AM - 12:00 PM)</option>
                      <option value="afternoon">Afternoon (12:00 PM - 4:00 PM)</option>
                      <option value="evening">Evening (4:00 PM - 8:00 PM)</option>
                    </select>
                  </div>
                </div>
                <div className="mt-6 flex justify-between">
                  <button
                    type="button"
                    onClick={prevStep}
                    className="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-md transition-colors"
                  >
                    Previous
                  </button>
                  <button
                    type="button"
                    onClick={nextStep}
                    className="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-md transition-colors"
                  >
                    Next Step
                  </button>
                </div>
              </div>
            )}

            {step === 3 && (
              <div>
                <h2 className="text-xl font-semibold mb-4">Waste Details</h2>
                <div className="space-y-4">
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Type of Waste</label>
                    <div className="space-y-2">
                      <div className="flex items-center">
                        <input
                          type="checkbox"
                          id="recyclables"
                          name="wasteType"
                          value="recyclables"
                          checked={formData.wasteType.includes("recyclables")}
                          onChange={handleCheckboxChange}
                          className="h-4 w-4 text-green-500 focus:ring-green-400"
                        />
                        <label htmlFor="recyclables" className="ml-2 text-sm text-gray-700">
                          Recyclables (Paper, Plastic, Glass, Metal)
                        </label>
                      </div>
                      <div className="flex items-center">
                        <input
                          type="checkbox"
                          id="electronics"
                          name="wasteType"
                          value="electronics"
                          checked={formData.wasteType.includes("electronics")}
                          onChange={handleCheckboxChange}
                          className="h-4 w-4 text-green-500 focus:ring-green-400"
                        />
                        <label htmlFor="electronics" className="ml-2 text-sm text-gray-700">
                          Electronics
                        </label>
                      </div>
                      <div className="flex items-center">
                        <input
                          type="checkbox"
                          id="organic"
                          name="wasteType"
                          value="organic"
                          checked={formData.wasteType.includes("organic")}
                          onChange={handleCheckboxChange}
                          className="h-4 w-4 text-green-500 focus:ring-green-400"
                        />
                        <label htmlFor="organic" className="ml-2 text-sm text-gray-700">
                          Organic Waste
                        </label>
                      </div>
                      <div className="flex items-center">
                        <input
                          type="checkbox"
                          id="hazardous"
                          name="wasteType"
                          value="hazardous"
                          checked={formData.wasteType.includes("hazardous")}
                          onChange={handleCheckboxChange}
                          className="h-4 w-4 text-green-500 focus:ring-green-400"
                        />
                        <label htmlFor="hazardous" className="ml-2 text-sm text-gray-700">
                          Hazardous Materials
                        </label>
                      </div>
                      <div className="flex items-center">
                        <input
                          type="checkbox"
                          id="bulky"
                          name="wasteType"
                          value="bulky"
                          checked={formData.wasteType.includes("bulky")}
                          onChange={handleCheckboxChange}
                          className="h-4 w-4 text-green-500 focus:ring-green-400"
                        />
                        <label htmlFor="bulky" className="ml-2 text-sm text-gray-700">
                          Bulky Items
                        </label>
                      </div>
                    </div>
                  </div>
                  <div>
                    <label htmlFor="notes" className="block text-sm font-medium text-gray-700 mb-1">
                      Additional Notes
                    </label>
                    <textarea
                      id="notes"
                      name="notes"
                      value={formData.notes}
                      onChange={handleChange}
                      rows={4}
                      className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                      placeholder="Any special instructions or details about your waste pickup..."
                    ></textarea>
                  </div>
                </div>
                <div className="mt-6 flex justify-between">
                  <button
                    type="button"
                    onClick={prevStep}
                    className="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-md transition-colors"
                  >
                    Previous
                  </button>
                  <button
                    type="button"
                    onClick={handleSubmit}
                    className="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-md transition-colors"
                  >
                    Submit Request
                  </button>
                </div>
              </div>
            )}

            {step === 4 && (
              <div className="text-center py-8">
                <div className="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-6">
                  <CheckCircle className="h-8 w-8 text-green-500" />
                </div>
                <h2 className="text-2xl font-bold text-gray-800 mb-2">Pickup Scheduled Successfully!</h2>
                <p className="text-gray-600 mb-6">
                  Thank you for scheduling a pickup. We've sent a confirmation email to {formData.email} with all the
                  details.
                </p>
                <div className="bg-gray-50 rounded-lg p-4 max-w-md mx-auto text-left">
                  <h3 className="font-medium text-gray-800 mb-2">Pickup Details:</h3>
                  <ul className="space-y-2 text-gray-600">
                    <li className="flex items-start">
                      <Calendar className="h-5 w-5 text-green-500 mr-2 mt-0.5" />
                      <span>
                        Date:{" "}
                        {new Date(formData.date).toLocaleDateString("en-US", {
                          weekday: "long",
                          year: "numeric",
                          month: "long",
                          day: "numeric",
                        })}
                      </span>
                    </li>
                    <li className="flex items-start">
                      <Clock className="h-5 w-5 text-green-500 mr-2 mt-0.5" />
                      <span>
                        Time:{" "}
                        {formData.time === "morning"
                          ? "Morning (8:00 AM - 12:00 PM)"
                          : formData.time === "afternoon"
                            ? "Afternoon (12:00 PM - 4:00 PM)"
                            : "Evening (4:00 PM - 8:00 PM)"}
                      </span>
                    </li>
                    <li className="flex items-start">
                      <MapPin className="h-5 w-5 text-green-500 mr-2 mt-0.5" />
                      <span>
                        Address: {formData.address}, {formData.city}, {formData.zipCode}
                      </span>
                    </li>
                  </ul>
                </div>
              </div>
            )}
          </div>
        </div>
      </div>
    </main>
  )
}
