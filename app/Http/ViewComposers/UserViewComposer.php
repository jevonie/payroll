<?php
namespace App\Http\ViewComposers;

use App\Models\{Leave};
use Illuminate\Contracts\View\View;

class UserViewComposer {

    public function compose(View $view) {
        $leaves = Leave::where("employee_id", auth()->user()->employee_id)->where("status","<>","PENDING")->where("employee_notif", 1)->get();
        $view->with('user_counts', [
            'leaves_count' => $leaves->count(),
            'leaves' => $leaves,
        ]);
    }

}

?>