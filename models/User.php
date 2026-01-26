<?php
/**
 * User Model for EcoWaste Application
 */

class User {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    /**
     * Find user by email
     */
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ? AND status = 'active'");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Find user by ID
     */
    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ? AND status = 'active'");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Create new user
     */
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO users (
                email, password_hash, first_name, last_name, phone,
                account_type, company_name, email_verification_token
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        return $stmt->execute([
            $data['email'],
            $data['password_hash'],
            $data['first_name'],
            $data['last_name'],
            $data['phone'] ?? null,
            $data['account_type'],
            $data['company_name'] ?? null,
            $data['email_verification_token'] ?? null
        ]);
    }

    /**
     * Update user
     */
    public function update($id, $data) {
        $fields = [];
        $values = [];

        foreach ($data as $key => $value) {
            if ($key !== 'id') {
                $fields[] = "{$key} = ?";
                $values[] = $value;
            }
        }

        $values[] = $id;

        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }

    /**
     * Get user addresses
     */
    public function getAddresses($userId) {
        $stmt = $this->db->prepare("
            SELECT * FROM user_addresses 
            WHERE user_id = ? 
            ORDER BY is_default DESC, created_at ASC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Add user address
     */
    public function addAddress($userId, $addressData) {
        // If this is set as default, unset others
        if ($addressData['is_default']) {
            $stmt = $this->db->prepare("UPDATE user_addresses SET is_default = 0 WHERE user_id = ?");
            $stmt->execute([$userId]);
        }

        $stmt = $this->db->prepare("
            INSERT INTO user_addresses (
                user_id, address_line_1, address_line_2, city, state,
                postal_code, country, is_default
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        return $stmt->execute([
            $userId,
            $addressData['address_line_1'],
            $addressData['address_line_2'] ?? null,
            $addressData['city'],
            $addressData['state'],
            $addressData['postal_code'],
            $addressData['country'] ?? 'USA',
            $addressData['is_default'] ? 1 : 0
        ]);
    }

    /**
     * Get user environmental impact
     */
    public function getEnvironmentalImpact($userId, $year = null) {
        if (!$year) {
            $year = date('Y');
        }

        $stmt = $this->db->prepare("
            SELECT 
                month,
                total_recycled_weight,
                co2_saved,
                trees_saved,
                water_saved,
                recycling_rate
            FROM user_environmental_impact
            WHERE user_id = ? AND year = ?
            ORDER BY month ASC
        ");
        $stmt->execute([$userId, $year]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Update environmental impact
     */
    public function updateEnvironmentalImpact($userId, $month, $year, $impactData) {
        $stmt = $this->db->prepare("
            INSERT INTO user_environmental_impact 
            (user_id, month, year, total_recycled_weight, co2_saved, trees_saved, water_saved, recycling_rate)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
            total_recycled_weight = total_recycled_weight + VALUES(total_recycled_weight),
            co2_saved = co2_saved + VALUES(co2_saved),
            trees_saved = trees_saved + VALUES(trees_saved),
            water_saved = water_saved + VALUES(water_saved),
            recycling_rate = VALUES(recycling_rate)
        ");

        return $stmt->execute([
            $userId,
            $month,
            $year,
            $impactData['weight'],
            $impactData['co2_saved'],
            $impactData['trees_saved'],
            $impactData['water_saved'],
            $impactData['recycling_rate'] ?? 0
        ]);
    }

    /**
     * Verify email
     */
    public function verifyEmail($token) {
        $stmt = $this->db->prepare("
            UPDATE users 
            SET email_verified = 1, email_verification_token = NULL 
            WHERE email_verification_token = ?
        ");
        return $stmt->execute([$token]);
    }

    /**
     * Set password reset token
     */
    public function setPasswordResetToken($email, $token, $expiry) {
        $stmt = $this->db->prepare("
            UPDATE users 
            SET password_reset_token = ?, password_reset_expires = ? 
            WHERE email = ?
        ");
        return $stmt->execute([$token, $expiry, $email]);
    }

    /**
     * Reset password
     */
    public function resetPassword($token, $passwordHash) {
        $stmt = $this->db->prepare("
            UPDATE users 
            SET password_hash = ?, password_reset_token = NULL, password_reset_expires = NULL 
            WHERE password_reset_token = ? AND password_reset_expires > NOW()
        ");
        return $stmt->execute([$passwordHash, $token]);
    }
}
?>