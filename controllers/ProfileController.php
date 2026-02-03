<?php
/**
 * Profile Controller for EcoWaste Application
 */

require_once 'BaseController.php';

class ProfileController extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->requireAuth();
    }

    /**
     * Display user profile
     */
    public function index() {
        $userId = $this->user['id'];
        
        // Get user statistics
        $stats = $this->getUserStats($userId);
        
        // Get notification preferences
        $preferences = $this->getNotificationPreferences($userId);

        $data = [
            'title' => 'My Profile - EcoWaste',
            'user' => $this->user,
            'stats' => $stats,
            'preferences' => $preferences,
            'layout' => 'main'
        ];

        $this->render('profile/index', $data);
    }

    /**
     * Display addresses management
     */
    public function addresses() {
        $userId = $this->user['id'];
        $addresses = $this->getUserAddresses($userId);

        $data = [
            'title' => 'Manage Addresses - EcoWaste',
            'addresses' => $addresses,
            'layout' => 'main'
        ];

        $this->render('profile/addresses', $data);
    }

    /**
     * Update user profile
     */
    public function update() {
        if (!$this->isPost()) {
            Helpers::redirect('/profile');
        }

        $this->validateCSRF();

        $data = $this->getPostData([
            'first_name' => 'string',
            'last_name' => 'string',
            'email' => 'email',
            'phone' => 'string',
            'account_type' => 'string',
            'company_name' => 'string'
        ]);

        // Validate required fields
        if (empty($data['first_name']) || empty($data['last_name']) || empty($data['email'])) {
            $this->jsonResponse(['success' => false, 'message' => 'Please fill in all required fields']);
        }

        // Check if email is already taken by another user
        if ($data['email'] !== $this->user['email']) {
            $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
            $stmt->execute([$data['email'], $this->user['id']]);
            if ($stmt->fetch()) {
                $this->jsonResponse(['success' => false, 'message' => 'Email is already taken']);
            }
        }

        // Update user
        $query = "
            UPDATE users SET 
                first_name = ?, last_name = ?, email = ?, phone = ?, 
                account_type = ?, company_name = ?, updated_at = CURRENT_TIMESTAMP
            WHERE id = ?
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute([
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['phone'] ?? null,
            $data['account_type'],
            $data['account_type'] === 'business' ? ($data['company_name'] ?? null) : null,
            $this->user['id']
        ]);

        // Reload user data
        $this->loadUser();

        $this->jsonResponse(['success' => true, 'message' => 'Profile updated successfully']);
    }

    /**
     * Change password
     */
    public function changePassword() {
        if (!$this->isPost()) {
            Helpers::redirect('/profile');
        }

        $this->validateCSRF();

        $data = $this->getPostData([
            'current_password' => 'string',
            'new_password' => 'string',
            'confirm_password' => 'string'
        ]);

        // Validate
        if (empty($data['current_password']) || empty($data['new_password']) || empty($data['confirm_password'])) {
            $this->jsonResponse(['success' => false, 'message' => 'Please fill in all password fields']);
        }

        if ($data['new_password'] !== $data['confirm_password']) {
            $this->jsonResponse(['success' => false, 'message' => 'New passwords do not match']);
        }

        if (strlen($data['new_password']) < 8) {
            $this->jsonResponse(['success' => false, 'message' => 'Password must be at least 8 characters long']);
        }

        // Verify current password
        if (!password_verify($data['current_password'], $this->user['password_hash'])) {
            $this->jsonResponse(['success' => false, 'message' => 'Current password is incorrect']);
        }

        // Update password
        $newPasswordHash = password_hash($data['new_password'], PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("UPDATE users SET password_hash = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        $stmt->execute([$newPasswordHash, $this->user['id']]);

        $this->jsonResponse(['success' => true, 'message' => 'Password changed successfully']);
    }

    /**
     * Update notification preferences
     */
    public function notifications() {
        if (!$this->isPost()) {
            Helpers::redirect('/profile');
        }

        $this->validateCSRF();

        $preferences = $this->getPostData([
            'email_notifications' => 'bool',
            'sms_notifications' => 'bool',
            'monthly_report' => 'bool',
            'promotional_emails' => 'bool'
        ]);

        // Update or insert preferences
        $query = "
            INSERT INTO user_notification_preferences (user_id, email_notifications, sms_notifications, monthly_report, promotional_emails)
            VALUES (?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
                email_notifications = VALUES(email_notifications),
                sms_notifications = VALUES(sms_notifications),
                monthly_report = VALUES(monthly_report),
                promotional_emails = VALUES(promotional_emails)
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute([
            $this->user['id'],
            $preferences['email_notifications'] ?? 0,
            $preferences['sms_notifications'] ?? 0,
            $preferences['monthly_report'] ?? 0,
            $preferences['promotional_emails'] ?? 0
        ]);

        $this->jsonResponse(['success' => true, 'message' => 'Notification preferences updated']);
    }

    /**
     * Save address
     */
    public function saveAddress() {
        if (!$this->isPost()) {
            Helpers::redirect('/profile/addresses');
        }

        $this->validateCSRF();

        $data = $this->getPostData([
            'address_id' => 'int',
            'address_line_1' => 'string',
            'address_line_2' => 'string',
            'city' => 'string',
            'district' => 'string',
            'province' => 'string',
            'township' => 'string',
            'postal_code' => 'string',
            'country' => 'string',
            'is_default' => 'bool'
        ]);

        // Validate required fields
        if (empty($data['address_line_1']) || empty($data['city']) || empty($data['district']) || empty($data['province'])) {
            $this->jsonResponse(['success' => false, 'message' => 'Please fill in all required address fields']);
        }

        try {
            $this->db->beginTransaction();

            // If setting as default, unset other default addresses
            if (!empty($data['is_default'])) {
                $unsetDefault = $this->db->prepare("UPDATE user_addresses SET is_default = FALSE WHERE user_id = ?");
                $unsetDefault->execute([$this->user['id']]);
            }

            if (!empty($data['address_id'])) {
                // Update existing address
                $query = "
                    UPDATE user_addresses SET 
                        address_line_1 = ?, address_line_2 = ?, city = ?, district = ?, 
                        province = ?, township = ?, postal_code = ?, country = ?, 
                        is_default = ?, updated_at = CURRENT_TIMESTAMP
                    WHERE id = ? AND user_id = ?
                ";

                $stmt = $this->db->prepare($query);
                $stmt->execute([
                    $data['address_line_1'],
                    $data['address_line_2'] ?? null,
                    $data['city'],
                    $data['district'],
                    $data['province'],
                    $data['township'] ?? null,
                    $data['postal_code'] ?? null,
                    $data['country'],
                    $data['is_default'] ?? false,
                    $data['address_id'],
                    $this->user['id']
                ]);
            } else {
                // Insert new address
                $query = "
                    INSERT INTO user_addresses (
                        user_id, address_line_1, address_line_2, city, district, 
                        province, township, postal_code, country, is_default
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ";

                $stmt = $this->db->prepare($query);
                $stmt->execute([
                    $this->user['id'],
                    $data['address_line_1'],
                    $data['address_line_2'] ?? null,
                    $data['city'],
                    $data['district'],
                    $data['province'],
                    $data['township'] ?? null,
                    $data['postal_code'] ?? null,
                    $data['country'],
                    $data['is_default'] ?? false
                ]);
            }

            $this->db->commit();
            $this->jsonResponse(['success' => true, 'message' => 'Address saved successfully']);

        } catch (Exception $e) {
            $this->db->rollback();
            $this->jsonResponse(['success' => false, 'message' => 'Error saving address']);
        }
    }

    /**
     * Set default address
     */
    public function setDefaultAddress() {
        if (!$this->isPost()) {
            Helpers::redirect('/profile/addresses');
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $addressId = $input['address_id'] ?? null;

        if (!$addressId) {
            $this->jsonResponse(['success' => false, 'message' => 'Address ID is required']);
        }

        try {
            $this->db->beginTransaction();

            // Verify address belongs to user
            $verify = $this->db->prepare("SELECT id FROM user_addresses WHERE id = ? AND user_id = ?");
            $verify->execute([$addressId, $this->user['id']]);
            if (!$verify->fetch()) {
                $this->jsonResponse(['success' => false, 'message' => 'Address not found']);
            }

            // Unset all default addresses
            $unsetDefault = $this->db->prepare("UPDATE user_addresses SET is_default = FALSE WHERE user_id = ?");
            $unsetDefault->execute([$this->user['id']]);

            // Set new default
            $setDefault = $this->db->prepare("UPDATE user_addresses SET is_default = TRUE WHERE id = ?");
            $setDefault->execute([$addressId]);

            $this->db->commit();
            $this->jsonResponse(['success' => true, 'message' => 'Default address updated']);

        } catch (Exception $e) {
            $this->db->rollback();
            $this->jsonResponse(['success' => false, 'message' => 'Error updating default address']);
        }
    }

    /**
     * Delete address
     */
    public function deleteAddress() {
        if (!$this->isPost()) {
            Helpers::redirect('/profile/addresses');
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $addressId = $input['address_id'] ?? null;

        if (!$addressId) {
            $this->jsonResponse(['success' => false, 'message' => 'Address ID is required']);
        }

        // Check if user has more than one address
        $countQuery = $this->db->prepare("SELECT COUNT(*) as count FROM user_addresses WHERE user_id = ?");
        $countQuery->execute([$this->user['id']]);
        $count = $countQuery->fetch()['count'];

        if ($count <= 1) {
            $this->jsonResponse(['success' => false, 'message' => 'You cannot delete your only address']);
        }

        // Delete address
        $stmt = $this->db->prepare("DELETE FROM user_addresses WHERE id = ? AND user_id = ?");
        $stmt->execute([$addressId, $this->user['id']]);

        if ($stmt->rowCount() > 0) {
            $this->jsonResponse(['success' => true, 'message' => 'Address deleted successfully']);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Address not found']);
        }
    }

    /**
     * Get user statistics
     */
    private function getUserStats($userId) {
        $query = "
            SELECT 
                COUNT(*) as total_pickups,
                COALESCE(SUM(total_weight), 0) as total_weight
            FROM pickup_requests 
            WHERE user_id = ? AND status = 'completed'
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get user addresses
     */
    private function getUserAddresses($userId) {
        $query = "
            SELECT * FROM user_addresses 
            WHERE user_id = ? 
            ORDER BY is_default DESC, created_at DESC
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get notification preferences
     */
    private function getNotificationPreferences($userId) {
        $query = "
            SELECT email_notifications, sms_notifications, monthly_report, promotional_emails
            FROM user_notification_preferences 
            WHERE user_id = ?
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$userId]);
        $preferences = $stmt->fetch(PDO::FETCH_ASSOC);

        // Return default preferences if none exist
        if (!$preferences) {
            return [
                'email_notifications' => 1,
                'sms_notifications' => 0,
                'monthly_report' => 1,
                'promotional_emails' => 0
            ];
        }

        return $preferences;
    }
}
