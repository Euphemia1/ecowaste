<?php
/**
 * Legal Controller for EcoWaste Application
 */

require_once 'BaseController.php';

class LegalController extends BaseController {

    /**
     * Display privacy policy
     */
    public function privacy() {
        $data = [
            'title' => 'Privacy Policy - EcoWaste',
            'layout' => 'main'
        ];
        $this->render('legal/privacy', $data);
    }

    /**
     * Display terms of service
     */
    public function terms() {
        $data = [
            'title' => 'Terms of Service - EcoWaste',
            'layout' => 'main'
        ];
        $this->render('legal/terms', $data);
    }
}
