<?php
/**
 * Worker Controller for EcoWaste Application
 */

require_once 'BaseController.php';

class WorkerController extends BaseController {

    /**
     * Display worker application page
     */
    public function application() {
        $data = [
            'title' => 'Join EcoWaste\'s Green Team - Worker Application',
            'layout' => 'main'
        ];
        
        $this->render('worker/application', $data);
    }

    /**
     * Display worker dashboard
     */
    public function dashboard() {
        // Implementation for worker dashboard would go here
        echo "Worker Dashboard - Coming Soon";
    }
}
