<?php
    namespace App\Http\Interfaces;

    use Illuminate\Http\Request;

    interface ICheckFarmer {
        public function getFarmerData(Request $request);

        public function checkFarmer(Request $request);
    }
?>