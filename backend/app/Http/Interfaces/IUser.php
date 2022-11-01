<?php
    namespace App\Http\Interfaces;

    use Illuminate\Http\Request;
    use App\Http\Requests\UserRequest;

    interface IUser {
        public function Add_User(UserRequest $request); // იუზერის დამატების მეთოდი

        public function Edit_User(int $id, Request $request); // იუზერის რედაქტირების მეთოდი

        public function User_List(); // იუზერების სიის წამოღება ბაზიდან

        public function Delete_User(int $id); // იუზერის წაშლის მეთოდი

        public function Get_User(int $id); // იუზერის წამოღება ბაზიდან
    }
?>