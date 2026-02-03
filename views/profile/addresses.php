<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="bg-white shadow-sm rounded-lg mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="/profile" class="text-gray-500 hover:text-gray-700 mr-4">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Manage Addresses</h1>
                        <p class="mt-1 text-sm text-gray-500">Add and manage your pickup locations</p>
                    </div>
                </div>
                <button onclick="showAddAddressModal()" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm">
                    <i class="fas fa-plus mr-2"></i> Add Address
                </button>
            </div>
        </div>
    </div>

    <!-- Addresses List -->
    <div class="space-y-4">
        <?php if (!empty($addresses)): ?>
            <?php foreach ($addresses as $address): ?>
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-map-marker-alt text-green-600"></i>
                                </div>
                                <div>
                                    <div class="flex items-center">
                                        <h3 class="text-lg font-medium text-gray-900">
                                            <?php echo Security::escape($address['address_line_1']); ?>
                                        </h3>
                                        <?php if ($address['is_default']): ?>
                                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Default
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ($address['address_line_2']): ?>
                                        <p class="text-gray-600 mt-1"><?php echo Security::escape($address['address_line_2']); ?></p>
                                    <?php endif; ?>
                                    <div class="mt-2 text-sm text-gray-500">
                                        <p><?php echo Security::escape($address['district']); ?>, <?php echo Security::escape($address['city']); ?></p>
                                        <p><?php echo Security::escape($address['province']); ?>, <?php echo Security::escape($address['country']); ?></p>
                                        <?php if ($address['postal_code']): ?>
                                            <p>Postal Code: <?php echo Security::escape($address['postal_code']); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2 ml-4">
                                <button onclick="editAddress(<?php echo $address['id']; ?>)" 
                                        class="text-blue-600 hover:text-blue-700">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <?php if (!$address['is_default']): ?>
                                    <button onclick="setDefault(<?php echo $address['id']; ?>)" 
                                            class="text-green-600 hover:text-green-700" title="Set as default">
                                        <i class="fas fa-star"></i>
                                    </button>
                                <?php endif; ?>
                                <?php if (count($addresses) > 1): ?>
                                    <button onclick="deleteAddress(<?php echo $address['id']; ?>)" 
                                            class="text-red-600 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                <i class="fas fa-map-marked-alt text-gray-300 text-5xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No addresses yet</h3>
                <p class="text-gray-500 mb-6">Add your first address to start scheduling pickups</p>
                <button onclick="showAddAddressModal()" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    <i class="fas fa-plus mr-2"></i> Add Address
                </button>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Add/Edit Address Modal -->
<div id="addressModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-10 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Add New Address</h3>
            <button onclick="closeAddressModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="addressForm" method="POST" action="/profile/addresses/save">
            <input type="hidden" name="csrf_token" value="<?php echo Security::generateCSRFToken(); ?>">
            <input type="hidden" name="address_id" id="addressId">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Address Line 1 *</label>
                    <input type="text" name="address_line_1" id="addressLine1" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Address Line 2</label>
                    <input type="text" name="address_line_2" id="addressLine2"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">City/Town *</label>
                    <input type="text" name="city" id="city" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">District *</label>
                    <select name="district" id="district" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">Select District</option>
                        <option value="Lusaka">Lusaka</option>
                        <option value="Kafue">Kafue</option>
                        <option value="Chongwe">Chongwe</option>
                        <option value="Rufunsa">Rufunsa</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Province *</label>
                    <select name="province" id="province" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">Select Province</option>
                        <option value="Lusaka">Lusaka</option>
                        <option value="Central">Central</option>
                        <option value="Copperbelt">Copperbelt</option>
                        <option value="Eastern">Eastern</option>
                        <option value="Muchinga">Muchinga</option>
                        <option value="Northern">Northern</option>
                        <option value="North-Western">North-Western</option>
                        <option value="Southern">Southern</option>
                        <option value="Western">Western</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Township/Area</label>
                    <input type="text" name="township" id="township"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Postal Code</label>
                    <input type="text" name="postal_code" id="postalCode"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Country *</label>
                    <select name="country" id="country" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="Zambia">Zambia</option>
                    </select>
                </div>
                
                <div class="md:col-span-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_default" id="isDefault" class="mr-2">
                        <span class="text-sm text-gray-700">Set as default address</span>
                    </label>
                </div>
            </div>
            
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" onclick="closeAddressModal()" 
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    <i class="fas fa-save mr-2"></i> Save Address
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let editingAddressId = null;

document.addEventListener('DOMContentLoaded', function() {
    // Auto-select province based on district
    document.getElementById('district').addEventListener('change', function() {
        const districtProvinceMap = {
            'Lusaka': 'Lusaka',
            'Kafue': 'Lusaka',
            'Chongwe': 'Lusaka',
            'Rufunsa': 'Lusaka'
        };
        
        const province = districtProvinceMap[this.value];
        if (province) {
            document.getElementById('province').value = province;
        }
    });
    
    // Form submission
    document.getElementById('addressForm').addEventListener('submit', function(e) {
        e.preventDefault();
        saveAddress();
    });
});

function showAddAddressModal() {
    editingAddressId = null;
    document.getElementById('modalTitle').textContent = 'Add New Address';
    document.getElementById('addressForm').reset();
    document.getElementById('addressModal').classList.remove('hidden');
}

function editAddress(addressId) {
    editingAddressId = addressId;
    document.getElementById('modalTitle').textContent = 'Edit Address';
    
    // Load address data (in a real app, this would be an AJAX call)
    const address = <?php echo json_encode($addresses); ?>.find(a => a.id == addressId);
    
    if (address) {
        document.getElementById('addressId').value = address.id;
        document.getElementById('addressLine1').value = address.address_line_1;
        document.getElementById('addressLine2').value = address.address_line_2 || '';
        document.getElementById('city').value = address.city;
        document.getElementById('district').value = address.district;
        document.getElementById('province').value = address.province;
        document.getElementById('township').value = address.township || '';
        document.getElementById('postalCode').value = address.postal_code || '';
        document.getElementById('country').value = address.country;
        document.getElementById('isDefault').checked = address.is_default;
        
        document.getElementById('addressModal').classList.remove('hidden');
    }
}

function closeAddressModal() {
    document.getElementById('addressModal').classList.add('hidden');
    document.getElementById('addressForm').reset();
    editingAddressId = null;
}

function saveAddress() {
    const formData = new FormData(document.getElementById('addressForm'));
    
    fetch('/profile/addresses/save', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeAddressModal();
            location.reload();
        } else {
            alert(data.message || 'Error saving address. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error saving address. Please try again.');
    });
}

function setDefault(addressId) {
    if (confirm('Set this address as your default pickup location?')) {
        fetch('/profile/addresses/set-default', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                address_id: addressId,
                csrf_token: '<?php echo Security::generateCSRFToken(); ?>'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Error updating default address.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating default address.');
        });
    }
}

function deleteAddress(addressId) {
    if (confirm('Are you sure you want to delete this address?')) {
        fetch('/profile/addresses/delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                address_id: addressId,
                csrf_token: '<?php echo Security::generateCSRFToken(); ?>'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Error deleting address.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting address.');
        });
    }
}
</script>
