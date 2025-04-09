import { Recycle, Trash2, Battery, Leaf } from "lucide-react"

export default function RecyclingGuidePage() {
  return (
    <main className="min-h-screen py-12">
      <div className="container mx-auto px-4 md:px-6">
        <div className="max-w-3xl mx-auto">
          <h1 className="text-3xl md:text-4xl font-bold text-center mb-8">Recycling Guide</h1>
          <p className="text-lg text-gray-600 text-center mb-12">
            Learn how to properly sort and recycle different types of waste materials to maximize your environmental
            impact.
          </p>

          {/* Materials Categories */}
          <div className="space-y-12">
            {/* Paper */}
            <section className="bg-white p-6 rounded-lg shadow-md">
              <div className="flex items-center mb-4">
                <div className="bg-blue-100 p-2 rounded-full mr-4">
                  <Recycle className="h-6 w-6 text-blue-500" />
                </div>
                <h2 className="text-2xl font-semibold">Paper & Cardboard</h2>
              </div>

              <div className="space-y-4">
                <p className="text-gray-600">
                  Paper and cardboard are highly recyclable materials. Make sure they are clean and dry before
                  recycling.
                </p>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <h3 className="font-medium text-gray-800 mb-2">Recyclable Items:</h3>
                    <ul className="list-disc list-inside text-gray-600 space-y-1">
                      <li>Newspapers and magazines</li>
                      <li>Office paper and envelopes</li>
                      <li>Cardboard boxes (flattened)</li>
                      <li>Paper bags</li>
                      <li>Paperboard packaging</li>
                    </ul>
                  </div>

                  <div>
                    <h3 className="font-medium text-gray-800 mb-2">Non-Recyclable Items:</h3>
                    <ul className="list-disc list-inside text-gray-600 space-y-1">
                      <li>Soiled or greasy paper</li>
                      <li>Waxed paper</li>
                      <li>Paper towels and napkins</li>
                      <li>Receipts (thermal paper)</li>
                      <li>Laminated paper</li>
                    </ul>
                  </div>
                </div>

                <div className="bg-blue-50 p-4 rounded-md">
                  <h3 className="font-medium text-gray-800 mb-2">Pro Tips:</h3>
                  <ul className="list-disc list-inside text-gray-600 space-y-1">
                    <li>Remove tape, staples, and plastic windows from envelopes</li>
                    <li>Flatten cardboard boxes to save space</li>
                    <li>Keep paper dry and clean</li>
                  </ul>
                </div>
              </div>
            </section>

            {/* Plastics */}
            <section className="bg-white p-6 rounded-lg shadow-md">
              <div className="flex items-center mb-4">
                <div className="bg-green-100 p-2 rounded-full mr-4">
                  <Trash2 className="h-6 w-6 text-green-500" />
                </div>
                <h2 className="text-2xl font-semibold">Plastics</h2>
              </div>

              <div className="space-y-4">
                <p className="text-gray-600">
                  Not all plastics are created equal. Check the recycling number (1-7) on the bottom of plastic items to
                  determine recyclability.
                </p>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <h3 className="font-medium text-gray-800 mb-2">Commonly Recyclable Plastics:</h3>
                    <ul className="list-disc list-inside text-gray-600 space-y-1">
                      <li>#1 PET (water bottles, soda bottles)</li>
                      <li>#2 HDPE (milk jugs, detergent bottles)</li>
                      <li>#5 PP (yogurt containers, bottle caps)</li>
                    </ul>
                  </div>

                  <div>
                    <h3 className="font-medium text-gray-800 mb-2">Often Non-Recyclable Plastics:</h3>
                    <ul className="list-disc list-inside text-gray-600 space-y-1">
                      <li>#3 PVC (pipes, window frames)</li>
                      <li>#4 LDPE (plastic bags, squeeze bottles)</li>
                      <li>#6 PS (styrofoam, disposable cups)</li>
                      <li>#7 Other (mixed plastics)</li>
                    </ul>
                  </div>
                </div>

                <div className="bg-green-50 p-4 rounded-md">
                  <h3 className="font-medium text-gray-800 mb-2">Pro Tips:</h3>
                  <ul className="list-disc list-inside text-gray-600 space-y-1">
                    <li>Rinse containers to remove food residue</li>
                    <li>Remove caps and lids (recycle separately)</li>
                    <li>Check with your local recycling program for specific guidelines</li>
                  </ul>
                </div>
              </div>
            </section>

            {/* Electronics */}
            <section className="bg-white p-6 rounded-lg shadow-md">
              <div className="flex items-center mb-4">
                <div className="bg-yellow-100 p-2 rounded-full mr-4">
                  <Battery className="h-6 w-6 text-yellow-500" />
                </div>
                <h2 className="text-2xl font-semibold">Electronics & Batteries</h2>
              </div>

              <div className="space-y-4">
                <p className="text-gray-600">
                  Electronic waste contains valuable materials and potentially hazardous components that require special
                  handling.
                </p>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <h3 className="font-medium text-gray-800 mb-2">Recyclable E-Waste:</h3>
                    <ul className="list-disc list-inside text-gray-600 space-y-1">
                      <li>Computers and laptops</li>
                      <li>Mobile phones and tablets</li>
                      <li>Televisions and monitors</li>
                      <li>Printers and scanners</li>
                      <li>Batteries (all types)</li>
                    </ul>
                  </div>

                  <div>
                    <h3 className="font-medium text-gray-800 mb-2">Disposal Methods:</h3>
                    <ul className="list-disc list-inside text-gray-600 space-y-1">
                      <li>E-waste collection events</li>
                      <li>Retailer take-back programs</li>
                      <li>Certified e-waste recyclers</li>
                      <li>Municipal hazardous waste facilities</li>
                    </ul>
                  </div>
                </div>

                <div className="bg-yellow-50 p-4 rounded-md">
                  <h3 className="font-medium text-gray-800 mb-2">Pro Tips:</h3>
                  <ul className="list-disc list-inside text-gray-600 space-y-1">
                    <li>Back up and erase personal data before recycling devices</li>
                    <li>Never throw batteries in regular trash (fire hazard)</li>
                    <li>Consider donating working electronics</li>
                  </ul>
                </div>
              </div>
            </section>

            {/* Organic Waste */}
            <section className="bg-white p-6 rounded-lg shadow-md">
              <div className="flex items-center mb-4">
                <div className="bg-green-100 p-2 rounded-full mr-4">
                  <Leaf className="h-6 w-6 text-green-500" />
                </div>
                <h2 className="text-2xl font-semibold">Organic Waste</h2>
              </div>

              <div className="space-y-4">
                <p className="text-gray-600">
                  Organic waste can be composted to create nutrient-rich soil instead of sending it to landfills where
                  it produces methane.
                </p>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <h3 className="font-medium text-gray-800 mb-2">Compostable Items:</h3>
                    <ul className="list-disc list-inside text-gray-600 space-y-1">
                      <li>Fruit and vegetable scraps</li>
                      <li>Coffee grounds and filters</li>
                      <li>Eggshells</li>
                      <li>Yard trimmings and leaves</li>
                      <li>Uncoated paper products</li>
                    </ul>
                  </div>

                  <div>
                    <h3 className="font-medium text-gray-800 mb-2">Non-Compostable Items:</h3>
                    <ul className="list-disc list-inside text-gray-600 space-y-1">
                      <li>Meat and dairy products</li>
                      <li>Oils and fats</li>
                      <li>Pet waste</li>
                      <li>Diseased plants</li>
                      <li>Bioplastics (unless certified compostable)</li>
                    </ul>
                  </div>
                </div>

                <div className="bg-green-50 p-4 rounded-md">
                  <h3 className="font-medium text-gray-800 mb-2">Pro Tips:</h3>
                  <ul className="list-disc list-inside text-gray-600 space-y-1">
                    <li>Balance green materials (food scraps) with brown materials (leaves, paper)</li>
                    <li>Cut larger items into smaller pieces to speed up decomposition</li>
                    <li>Consider a worm bin for apartment composting</li>
                  </ul>
                </div>
              </div>
            </section>
          </div>
        </div>
      </div>
    </main>
  )
}
