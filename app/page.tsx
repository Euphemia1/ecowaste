import Link from "next/link";
import { 
  Leaf, 
  ChartBar, 
  Calendar, 
  BookOpen, 
  Recycle, 
  TreePine, 
  Droplets, 
  Wind,
  ArrowRight,
  Shield,
  Users,
  Clock,
  Star
} from "lucide-react";

export default function Home() {
  return (
    <div className="min-h-screen bg-gray-50 font-[family-name:var(--font-geist-sans)]">
      {/* Header */}
      <header className="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
          <div className="flex items-center justify-between">
            <div className="flex items-center gap-2">
              <Leaf className="w-8 h-8 text-green-500" />
              <h1 className="text-2xl font-bold text-gray-800">EcoWaste</h1>
            </div>
            <div className="flex items-center gap-4">
              <Link 
                href="/login"
                className="text-green-600 hover:text-green-500 font-medium transition-colors"
              >
                Sign In
              </Link>
              <Link 
                href="/get started"
                className="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-medium transition-colors"
              >
                Get Started
              </Link>
            </div>
          </div>
        </div>
      </header>

      {/* Hero Section */}
      <section className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
        <div className="text-center">
          <div className="inline-flex items-center gap-2 bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-medium mb-6">
            <Leaf className="w-4 h-4" />
            Sustainable Waste Management Platform
          </div>
          <h1 className="text-4xl lg:text-6xl font-bold text-gray-800 mb-6">
            🌱 Welcome to <span className="text-green-500">EcoWaste</span>
          </h1>
          <p className="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
            A comprehensive platform designed to promote sustainable waste management practices and environmental consciousness. 
            Track your impact, schedule pickups, and learn proper recycling techniques.
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Link 
              href="/get started"
              className="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-md font-medium transition-colors flex items-center gap-2 justify-center"
            >
              Get Started <ArrowRight className="w-4 h-4" />
            </Link>
            <Link 
              href="/impact dashboard"
              className="border border-green-600 text-green-600 hover:bg-green-50 px-8 py-3 rounded-md font-medium transition-colors flex items-center gap-2 justify-center"
            >
              <ChartBar className="w-4 h-4" />
              View Dashboard
            </Link>
          </div>
        </div>
      </section>

      {/* Features Section */}
      <section className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div className="text-center mb-12">
          <h2 className="text-3xl font-bold text-gray-800 mb-4">✨ Platform Features</h2>
          <p className="text-gray-600 text-lg">Everything you need for sustainable waste management</p>
        </div>

        <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
          {/* Impact Dashboard */}
          <Link href="/impact dashboard" className="group">
            <div className="bg-white p-6 rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-all group-hover:scale-105">
              <div className="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                <ChartBar className="w-6 h-6 text-blue-600" />
              </div>
              <h3 className="text-xl font-semibold text-gray-800 mb-2">📊 Impact Dashboard</h3>
              <p className="text-gray-600 mb-4">
                Track your environmental impact with interactive charts and real-time metrics
              </p>
              <div className="flex flex-wrap gap-2">
                <span className="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs">Recycling Rate</span>
                <span className="bg-green-50 text-green-700 px-2 py-1 rounded text-xs">Carbon Footprint</span>
              </div>
            </div>
          </Link>

          {/* Schedule Pickup */}
          <Link href="/schedule pickup" className="group">
            <div className="bg-white p-6 rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-all group-hover:scale-105">
              <div className="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                <Calendar className="w-6 h-6 text-green-600" />
              </div>
              <h3 className="text-xl font-semibold text-gray-800 mb-2">📅 Schedule Pickup</h3>
              <p className="text-gray-600 mb-4">
                Easy multi-step wizard for scheduling eco-friendly waste collection
              </p>
              <div className="flex flex-wrap gap-2">
                <span className="bg-green-50 text-green-700 px-2 py-1 rounded text-xs">All Waste Types</span>
                <span className="bg-purple-50 text-purple-700 px-2 py-1 rounded text-xs">Flexible Times</span>
              </div>
            </div>
          </Link>

          {/* Recycling Guide */}
          <Link href="/recycing guide" className="group">
            <div className="bg-white p-6 rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-all group-hover:scale-105">
              <div className="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center mb-4">
                <BookOpen className="w-6 h-6 text-emerald-600" />
              </div>
              <h3 className="text-xl font-semibold text-gray-800 mb-2">📚 Recycling Guide</h3>
              <p className="text-gray-600 mb-4">
                Comprehensive guidelines for proper recycling and waste disposal
              </p>
              <div className="flex flex-wrap gap-2">
                <span className="bg-emerald-50 text-emerald-700 px-2 py-1 rounded text-xs">Material Types</span>
                <span className="bg-orange-50 text-orange-700 px-2 py-1 rounded text-xs">Best Practices</span>
              </div>
            </div>
          </Link>

          {/* User Authentication */}
          <Link href="/login" className="group">
            <div className="bg-white p-6 rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-all group-hover:scale-105">
              <div className="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                <Shield className="w-6 h-6 text-indigo-600" />
              </div>
              <h3 className="text-xl font-semibold text-gray-800 mb-2">🔐 User Dashboard</h3>
              <p className="text-gray-600 mb-4">
                Secure authentication with individual and business account support
              </p>
              <div className="flex flex-wrap gap-2">
                <span className="bg-indigo-50 text-indigo-700 px-2 py-1 rounded text-xs">Secure Login</span>
                <span className="bg-gray-50 text-gray-700 px-2 py-1 rounded text-xs">Account Types</span>
              </div>
            </div>
          </Link>
        </div>
      </section>

      {/* Environmental Impact Stats */}
      <section className="bg-white py-16">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-bold text-gray-800 mb-4">Environmental Impact Tracking</h2>
            <p className="text-gray-600 text-lg">Monitor your contribution to a sustainable future</p>
          </div>
          
          <div className="grid md:grid-cols-3 gap-8">
            <div className="text-center">
              <div className="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <TreePine className="w-8 h-8 text-green-600" />
              </div>
              <h3 className="text-2xl font-bold text-gray-800 mb-2">Trees Saved</h3>
              <p className="text-gray-600">Track how your recycling efforts contribute to forest conservation</p>
            </div>
            
            <div className="text-center">
              <div className="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <Wind className="w-8 h-8 text-blue-600" />
              </div>
              <h3 className="text-2xl font-bold text-gray-800 mb-2">CO₂ Reduction</h3>
              <p className="text-gray-600">Monitor your carbon footprint reduction over time</p>
            </div>
            
            <div className="text-center">
              <div className="w-16 h-16 bg-cyan-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <Droplets className="w-8 h-8 text-cyan-600" />
              </div>
              <h3 className="text-2xl font-bold text-gray-800 mb-2">Water Conservation</h3>
              <p className="text-gray-600">See how much water you're helping to conserve</p>
            </div>
          </div>
        </div>
      </section>

      {/* Technology Stack */}
      <section className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div className="text-center mb-12">
          <h2 className="text-3xl font-bold text-gray-800 mb-4">🛠️ Built with Modern Technology</h2>
          <p className="text-gray-600 text-lg">Powered by industry-leading tools and frameworks</p>
        </div>
        
        <div className="grid grid-cols-2 md:grid-cols-4 gap-8">
          <div className="text-center">
            <div className="bg-gray-900 text-white px-4 py-2 rounded-lg font-mono text-sm mb-2">Next.js 15.5.3</div>
            <p className="text-gray-600 text-sm">React Framework</p>
          </div>
          <div className="text-center">
            <div className="bg-blue-600 text-white px-4 py-2 rounded-lg font-mono text-sm mb-2">TypeScript</div>
            <p className="text-gray-600 text-sm">Type Safety</p>
          </div>
          <div className="text-center">
            <div className="bg-cyan-500 text-white px-4 py-2 rounded-lg font-mono text-sm mb-2">Tailwind CSS</div>
            <p className="text-gray-600 text-sm">Modern Styling</p>
          </div>
          <div className="text-center">
            <div className="bg-purple-600 text-white px-4 py-2 rounded-lg font-mono text-sm mb-2">Recharts</div>
            <p className="text-gray-600 text-sm">Data Visualization</p>
          </div>
        </div>
      </section>

      {/* Call to Action */}
      <section className="bg-green-600 py-16">
        <div className="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
          <h2 className="text-3xl font-bold text-white mb-4">Ready to Start Your Eco Journey?</h2>
          <p className="text-green-100 text-lg mb-8">
            Join thousands of users making a positive environmental impact through sustainable waste management
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Link 
              href="/get started"
              className="bg-white text-green-600 hover:bg-gray-50 px-8 py-3 rounded-md font-medium transition-colors flex items-center gap-2 justify-center"
            >
              Create Account <ArrowRight className="w-4 h-4" />
            </Link>
            <Link 
              href="/recycing guide"
              className="border border-white text-white hover:bg-white/10 px-8 py-3 rounded-md font-medium transition-colors flex items-center gap-2 justify-center"
            >
              <BookOpen className="w-4 h-4" />
              Learn More
            </Link>
          </div>
        </div>
      </section>

      {/* Footer */}
      <footer className="bg-gray-900 text-white py-12">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid md:grid-cols-4 gap-8">
            <div>
              <div className="flex items-center gap-2 mb-4">
                <Leaf className="w-6 h-6 text-green-400" />
                <span className="text-xl font-bold">EcoWaste</span>
              </div>
              <p className="text-gray-400">
                Sustainable waste management platform promoting environmental consciousness and eco-friendly practices.
              </p>
            </div>
            
            <div>
              <h3 className="font-semibold mb-4">Features</h3>
              <div className="space-y-2">
                <Link href="/impact dashboard" className="block text-gray-400 hover:text-white transition-colors">Impact Dashboard</Link>
                <Link href="/schedule pickup" className="block text-gray-400 hover:text-white transition-colors">Schedule Pickup</Link>
                <Link href="/recycing guide" className="block text-gray-400 hover:text-white transition-colors">Recycling Guide</Link>
              </div>
            </div>
            
            <div>
              <h3 className="font-semibold mb-4">Account</h3>
              <div className="space-y-2">
                <Link href="/login" className="block text-gray-400 hover:text-white transition-colors">Sign In</Link>
                <Link href="/get started" className="block text-gray-400 hover:text-white transition-colors">Get Started</Link>
              </div>
            </div>
            
            <div>
              <h3 className="font-semibold mb-4">Impact</h3>
              <div className="space-y-2">
                <div className="flex items-center gap-2 text-gray-400">
                  <Recycle className="w-4 h-4" />
                  <span>Recycling Tracking</span>
                </div>
                <div className="flex items-center gap-2 text-gray-400">
                  <TreePine className="w-4 h-4" />
                  <span>Tree Conservation</span>
                </div>
                <div className="flex items-center gap-2 text-gray-400">
                  <Wind className="w-4 h-4" />
                  <span>Carbon Reduction</span>
                </div>
              </div>
            </div>
          </div>
          
          <div className="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
            <p>&copy; 2025 EcoWaste. Building a sustainable future through responsible waste management.</p>
          </div>
        </div>
      </footer>
    </div>
  );
}
