<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class MainController extends Controller
{
    public function chooseCleaner() {
        $cleaners = DB::table('users')->where('role_id', '=', 2)->get();
        return view('chooseCleaner',compact('cleaners'));
    }

    /*public function makeOrder(Request $request, $id) {
        dd($id);
        $request->has(role);
        return view('makeOrder');
    }*/

    public function registrate(Request $request) {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        //return DB::table('roles')->get();
    }

    public function getUser(Request $request) {
        if(Auth::check()){
            return Auth::user();
        }
        else {
            abort(401);
        }
    }

    public function logout(Request $request) {
        Auth::logout();       
    }

    public function getOrders(Request $request) {
        if(Auth::check()){
            if(Auth::user()-> role_id === 1 ) {
                return DB::select('select o.id, u.name, o.rooms_amount, o.additional_services, o.order_date_time, o.total_price, o.address
                from orders o join users u on u.id = o.cleaner_id where client_id = ?', [$request->id]);
            }
            else {
                abort(401);
            }
        }
        else {
            abort(401);
        }
    }

    public function additionalServices(Request $request) {
        if(Auth::check()){
            return DB::select('select * from additional_services');
        }
    }

    public function makeOrder(Request $request) {
        if(Auth::check()){
            if(Auth::user()->role_id === 1) {
                Order::create([
                'rooms_amount' => $request->rooms_amount,
                'total_price' => $request->total_cost,
                'client_id' => $request->user_id,
                'cleaner_id' => $request->cleaner_id,
                'address' => $request->address,
                'order_date_time' => $request->orderDate,
                'phone_number' => $request->phone,
                'additional_services' => $request->services]);
            }
            else {
                abort(401);
            }
        }
        else {
            abort(401);
        }
    }

    public function deleteActiveOrder(Request $request) {
        if(Auth::check()){
            if(Auth::user()->role_id === 1 || Auth::user()->role_id === 2) {
                DB::delete('delete from orders where id = ?',[$request->id]);
                dd($request->id);
            }
            else {
                abort(401);
            }
        }
        else {
            abort(401);
        }
    }

    public function cancelOrder(Request $request) {
        if(Auth::check()){
            if(Auth::user()->role_id === 2)
                DB::delete('delete from orders where id = ?',[$request->id]);
        }
    }

    public function addActiveReview(Request $request) {
        if(Auth::check()){
            if(Auth::user()->role_id === 2)
                DB::insert('insert into active_reviews values (?,?,null) on conflict do nothing',[$request->client_id,Auth::user()->id]);
        }
    }

    public function getUserReviews() {
        if(Auth::check()){
            if(Auth::user()->role_id === 1) {
                return DB::select('select user_id, a.cleaner_id, review_id, rating, review_title, review_text, u.name
                from active_reviews a 
                left join reviews r on r.id = a.review_id
                join users u on u.id = a.cleaner_id
                where user_id = ?',[Auth::user()->id]);
            }
            else {
                abort(401);
            }
        }
        else {
            abort(401);
        }
    }

    public function login(Request $request) {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if(Auth::attempt($request->only('email','password'))){
            return Auth::user();
        }
        throw ValidationException::withMessages([
            'email' => ['Неверные данные для входа']
        ]);
        //return DB::table('roles')->get();
    }

    public function makeReview(Request $request){
        if(Auth::check()){
            if(Auth::user()->role_id === 1) {
                $id = Review::create([
                    'client_id' => Auth::user()->id,
                    'cleaner_id' => $request->cleaner_id,
                    'rating' => $request->rating,
                    'review_title' => $request->review_title,
                    'review_text' => $request->review_text
                ])->id;
                DB::update('update active_reviews 
                set review_id = ? 
                where cleaner_id = ? and user_id = ?',[$id,$request->cleaner_id,Auth::user()->id]);
                return $id;
            }
            else {
                abort(401);
            }
        }
        else {
            abort(401);
        }
    }

    public function getCleanerReviews(Request $request){
        if(Auth::check()){
            if(Auth::user()->role_id === 1) {
                //dd($request);
                return DB::select('select r.rating, r.review_title, r.review_text, u.name
                from reviews r
                join users u on u.id = r.client_id
                where r.cleaner_id = ?',[$request->id]);
            }
            else {
                abort(401);
            }
        }
        else {
            abort(401);
        }
    }

    public function getCleanersInfo(Request $request) {
        if(Auth::check()){
            return DB::select('select u.name as cleaner_name, u.id, round(avg(rating),2) as rating, count(*) as reviews_amount from reviews r join users u on r.cleaner_id = u.id group by u.name, u.id');
        }
    }

    public function getCleanersReviews(Request $request){
        if(Auth::check()){
            if(Auth::user()->role_id === 3){
                if($request->id == null){
                    return DB::select('select count(rating) FILTER (WHERE rating = 5) as five_mark,
                    count(rating) FILTER (WHERE rating = 4) as four_mark,
                    count(rating) FILTER (WHERE rating = 3) as three_mark,
                    count(rating) FILTER (WHERE rating = 2) as two_mark,
                    count(rating) FILTER (WHERE rating = 1) as one_mark,
                    count(rating) as all_marks,
                    count(a.cleaner_id) FILTER (WHERE a.review_id IS NULL) as no_marks
                    from reviews
                    right join active_reviews a on a.review_id = reviews.id
                    '
                    );
                }
                else{
                    return DB::select('select count(rating) FILTER (WHERE rating = 5) as five_mark,
                    count(rating) FILTER (WHERE rating = 4) as four_mark,
                    count(rating) FILTER (WHERE rating = 3) as three_mark,
                    count(rating) FILTER (WHERE rating = 2) as two_mark,
                    count(rating) FILTER (WHERE rating = 1) as one_mark,
                    count(rating) as all_marks,
                    count(a.cleaner_id) FILTER (WHERE a.review_id IS NULL) as no_marks
                    from reviews
                    right join active_reviews a on a.review_id = reviews.id
                    where a.cleaner_id = ?
                    ',[$request->id]);
                }
            }
        }
    }

    public function getReviews(Request $request){
        if(Auth::check()){
            if(Auth::user()->role_id === 3){
                if($request->curCleanerId == null){
                    return DB::select('select u.name as user_name, cl.name as cleaner_name, rating, r.review_text, r.review_title
                        from reviews r
                        join users u on u.id = r.client_id
                        join users cl on cl.id = r.cleaner_id
                        order by rating desc'
                    );
                }
                else{
                    return DB::select('select u.name as user_name, cl.name as cleaner_name, rating, r.review_text, r.review_title
                    from reviews r
                    join users u on u.id = r.client_id
                    join users cl on cl.id = r.cleaner_id
                    where r.cleaner_id = ?
                    order by rating desc
                    ',[$request->curCleanerId]);
                }
            }
        }
    }

    public function getAllCleaners(Request $request){
        if(Auth::check()){
            if(Auth::user()->role_id === 3) {
                //dd($request);
                return DB::select('select u.id, u.email, u.name, coalesce(round(avg(r.rating),2),0) as rating, count(r) as reviews_amount
                from users u
                left join reviews r on r.cleaner_id = u.id
                where u.role_id = 2
                group by u.email, u.name, u.id');
            }
            else {
                abort(401);
            }
        }
        else {
            abort(401);
        }
    }

    public function deleteCleanerAccount(Request $request){
        if(Auth::check()){
            if(Auth::user()->role_id === 3) {
                //dd($request);
                return DB::delete('delete from users where id = ?',[$request->id]);
            }
            else {
                abort(401);
            }
        }
        else {
            abort(401);
        }
    }

    public function redactReview(Request $request){
        if(Auth::check()){
            if(Auth::user()->role_id === 1) {
                DB::enableQueryLog();
                /*
                DB::update('update reviews 
                set rating = ?, review_title = ?, review_text = ? 
                where id = ?',[$request->rating,$request->review_title,$request->review_text,$request->review_id]);*/
                DB::table('reviews')
                    ->where('id','=',$request->review_id)
                    ->update(['rating' => $request->rating, 
                    'review_title' => $request->review_title,
                    'review_text' => $request->review_text]);
                dd(DB::getQueryLog());
            }
            else {
                abort(401);
            }
        }
        else {
            abort(401);
        }
    }

    public function registrateCleaner(Request $request) {
        if(Auth::check()) {
            if(Auth::user()->role_id === 3) {
                $request->validate([
                    'name' => ['required'],
                    'email' => ['required', 'email', 'unique:users'],
                    'password' => ['required', 'min:6'],
                ]);

                User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role_id' => 2
                ]);
            }
            else {
                abort(401);
            }
        }
        else {
            abort(401);
        }
    }

    public function getCleanerOrders(Request $request) {
        if(Auth::check()){
            return DB::select('select o.id, u.name, o.client_id, o.rooms_amount, o.additional_services, o.order_date_time, o.address, o.phone_number
            from orders o join users u on u.id = o.client_id where cleaner_id = ?', [$request->id]);
        }
    }

    public function updateService(Request $request){
        if(Auth::check()){
            if(Auth::user()->role_id === 3) {
                //dd($request);
                $request->validate([
                    'service_name' => ['required'],
                    'service_cost' => ['required', 'numeric', 'min:250', 'max:10000'],
                ]);
                return DB::update('update additional_services 
                set service_cost = ? 
                where service_name = ?',[$request->service_cost,$request->service_name]);
            }
            else {
                abort(401);
            }
        }
        else {
            abort(401);
        }
    }

    public function addService(Request $request){
        if(Auth::check()){
            if(Auth::user()->role_id === 3) {
                $request->validate([
                    'service_name' => ['required', 'min:5'],
                    'service_cost' => ['required', 'numeric', 'min:250', 'max:10000'],
                ]);
                DB::insert('insert into additional_services values(?,?)',[$request->service_name,$request->service_cost]);
            }
            else {
                abort(401);
            }
        }
        else {
            abort(401);
        }
    }

    public function deleteService(Request $request){
        if(Auth::check()){
            if(Auth::user()->role_id === 3) {
                //dd($request);
                return DB::delete('delete from additional_services where service_name = ?',[$request->service_name]);
            }
            else {
                abort(401);
            }
        }
        else {
            abort(401);
        }
    }

    public function searchReviews(Request $request){
        //dd($request);
        if(Auth::check()){
            if(Auth::user()->role_id === 1) {
                //dd($request);
                DB::enableQueryLog();
                return DB::select('select r.rating, r.review_title, r.review_text, u.name
                from reviews r
                join users u on u.id = r.client_id
                where r.cleaner_id = ? and 
                (lower(review_title) like lower(?) or lower(review_text) like lower(?))',[$request->id,$request->text,$request->text]);
                dd(DB::getQueryLog());
            }
            else {
                abort(401);
            }
        }
        else {
            abort(401);
        }
    }

    public function updateUserData(Request $request){
        if(Auth::check()){

            //dd($request->email);
            $request->validate([
                'email' => ['email']
            ]);

            DB::update('update users set name = ?, email = ? where id = ?',[$request->username,$request->email,Auth::user()->id]);
            if($request->has('old_password','new_password')){
                $request->validate([
                    'new_password' => ['min:6']
                ]);
                if(Auth::attempt(['email' => $request->email, 'password' => $request->old_password])){
                    dd(DB::update('update users set password = ? where id = ?',[Hash::make($request->new_password),Auth::user()->id]));
                }
            }
            Auth::attempt(['email' => $request->email, 'password' => $request->old_password]);
        }
    }

    public function getReviewsOnCleaner(Request $request){
        if(Auth::check() && Auth::user()->role_id === 2){
            return DB::select('select u.name as user_name, cl.name as cleaner_name, rating, r.review_text, r.review_title
            from reviews r
            join users u on u.id = r.client_id
            join users cl on cl.id = r.cleaner_id
            where r.cleaner_id = ?
            order by rating desc
            ',[Auth::user()->id]);
        }
    }

    public function getAllUsersInfo(){
        if(Auth::check() && Auth::user()->role_id === 3){
            return DB::select('select u.id, u.name, u.email, r.role_name, u.created_at 
            from users u 
            join roles r on r.id = u.role_id 
            order by u.id');
        }
    }
}
