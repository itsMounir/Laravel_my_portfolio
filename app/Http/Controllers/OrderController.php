<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Auth;
use Illuminate\Http\Request;
use Validator;

class OrderController extends Controller
{

    public function update($storehouse_id,Request $request) {

        $validator = Validator::make($request->all(), [
            'data' => ['array' , 'present'],
            'data.*.order_id' => 'required',
            'data.*.state' => 'required',
            'data.*.paying_state' => 'required',
        ]);

        //dd($validator->validated());

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(),400);
        }
        //dd($request->all());
        $user = Auth::user();
        //dd($user->storehouse()->get()[0]['id']);
        if (! $user['role'] || $user->storehouse()->get()[0]['id'] != (int)$storehouse_id) {
            return response()->json(['message' => 'unauthorized' , 'status'=> 401]);
        }

        //dd($user->storehouse()->get()[0]->orders()->getResults()[0]);


        // $orders = $user->storehouse()->get()[0]->orders()->getResults()[0]
        // ->with(['order_products'])
        // ->get();


        //dd($orders);

        $orders = [];

        foreach ($request['data'] as $myOrder) {
            $order = Order::firstWhere('id','=',$myOrder['order_id']);
            //dd($order);
            $order['state'] =$myOrder['state'];
            $order['paying_state'] =$myOrder['paying_state'];
            $order->save();

            $orders[]= $order;
        }
        return response()->json([
            'message' => 'success',
            'data' => $orders,
            'status' =>200
        ]);


    }


    public function store($storehouse_id,Request $request) {

        return response()->json([
            'message' => $request->all()
        ]);

        $validator = Validator::make($request->all(), [
            'data' => ['array' , 'present'],
            'data.*.product_id' => 'required',
            'data.*.amount' => 'required',
        ]);

        //dd($validator->validated());

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(),400);
        }
        //dd($orders);

        $check = true;
        $order_products = [];

        foreach ($request['data'] as $myOrder) {
            $product = Product::firstwhere('id','=',$myOrder['product_id']);
            //dd((int)$storehouse_id);
            //dd($product->storehouse()->get()[0]['id']);

            if ($product->storehouse()->get()[0]['id'] != (int)$storehouse_id) {
                return response()->json([
                    'message' => 'your order is not available in our warehouse, please try later.',
                    'data' => $product,
                ],500);

            if (! $product || ($product['amount'] < $myOrder['amount'])) {
                $check = false;
                return response()->json([
                    'message' => 'your order is not available rightnow, please try later.',
                    'data' => $product,
                ],500);
            }
            }
        }


        if ($check) {
        foreach ($request['data'] as $myOrder) {
            //dd($order);
            $product = Product::firstwhere('id','=',$myOrder['product_id']);
            //dd($product);

            $user = Auth::user();
            //dd(!$user['role']);
            if ($user['role']) {
                return response()->json(['message' => 'unauthorized' , 'status'=> 401]);
            }

            if (! $product || ($product['amount'] < $myOrder['amount'])) {
                return response()->json(['message' => 'your order is not available rightnow, please try later.' , 500]);
            }

            $product['amount'] -= $myOrder['amount'];
            $product->save();
            // every thing is manually


            $order = Order::create([
                'state' => 'prepairing' ,
                'paying_state' => 'not_payed',
                'user_id' => $user->id,
                'storehouse_id' => $storehouse_id,
            ]);

            //dd($myOrder['amount']);

            $order_product = OrderProduct::create([
                'product_id' => $product->id ,
                'order_id' => $order->id ,
                'amount' => $myOrder['amount'],
            ]);

            $order_products[] = OrderProduct::select('id','product_id','order_id','amount')
            ->with(['order','product','order.user','order.storehouse'])
            ->find($order_product['id']);

        }

        return response()->json([
            'message' => 'success',
            'data' => $order_products
        ],200);
    }

    }

    public function delete($storehouse_id,Request $request) {

        //dd($request);
        $validator = Validator::make($request->all(), [
            'data' => ['array' , 'present'],
            'data.*.product_id' => 'required',
            'data.*.amount' => 'required',
        ]);

        //dd($validator->validated());

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(),400);
        }
        //dd($orders);

        $check = true;
        $order_products = [];

        foreach ($request['data'] as $myOrder) {
            $product = Product::firstwhere('id','=',$myOrder['product_id']);
            //dd((int)$storehouse_id);
            //dd($product->storehouse()->get()[0]['id']);

            if ($product->storehouse()->get()[0]['id'] != (int)$storehouse_id) {
                return response()->json([
                    'message' => 'invalid.',
                ],500);

            if (! $product) {
                $check = false;
                return response()->json([
                    'message' => 'invalid.',
                    'data' => $product,
                ],500);
            }
            }
        }


        if ($check) {
        foreach ($request['data'] as $myOrder) {
            //dd($order);
            $product = Product::firstwhere('id','=',$myOrder['product_id']);
            //dd($product);

            $user = Auth::user();
            //dd(!$user['role']);
            if ($user['role']) {
                return response()->json(['message' => 'unauthorized' , 'status'=> 401]);
            }

            if (! $product) {
                return response()->json(['message' => 'your order is not available rightnow, please try later.' , 500]);
            }

            $product['amount'] += $myOrder['amount'];
            $product->save();
            // every thing is manually


            $order = Order::Where('user_id','=',$user->id)->Where('storehouse_id','=',$storehouse_id)->first();

            //dd($myOrder['amount']);

            $order_product = OrderProduct::Where('product_id','=',$product->id)->Where('order_id','=',$order->id )->first();
            // return response()->json([
            //     'data' => $order_product
            // ]);
            // $order_products[] = OrderProduct::select('id','product_id','order_id','amount')
            // ->with(['order','product','order.user','order.storehouse'])
            // ->find($order_product['id']);

        }

        return response()->json([
            'message' => 'deleted successfully',
        ],200);
    }

    }

    public function index($storehouse_id) {
        $user = Auth::user();
        //dd($user->storehouse()->get()[0]['id']);
        if (! $user['role'] || $user->storehouse()->get()[0]['id'] != (int)$storehouse_id) {
            return response()->json(['message' => 'unauthorized' , 'status'=> 401]);
        }

        //dd($user->storehouse()->get()[0]->orders()->getResults()[0]);
        $orders = $user->storehouse()->get()[0]->orders()->getResults()[0]
        ->with(['order_products'])
        ->get();
        return response()->json([
            'message' => 'success',
            'data' => $orders,
        ]);
    }

    public function show() {
        $user = Auth::user();
        if ($user['role']) {
            return response()->json(['message' => 'unauthorized' , 'status'=> 401]);
        }
        $orders = $user->orders()
        ->with(['order_products'])
        ->get();
        return response()->json([
            'message' => 'success',
            'data' => $orders,
        ]);
    }



}






/*

public function order($warehouse_id,Request $request)
    {
        $user_id = Auth::id();

        if (!$user_id) {
            return $this->sendError('', ['error' => 'please make sure that you have loggedin'],401);
        }
        $medicin=[];
        $cart = Cart::query()->create([
            'phermesist_id' => $user_id,
            'warehouse_id'=> $warehouse_id,
            'status' => 'Preparing',
            'paymentStatus' => 'notPayed',
        ]);
        $items=$request->items;
        foreach ($items as $item) {
         $medicine=Medicin::find($item['id']);
         if($medicine&&$medicine->quantity>=$item['quantity']){
            $cart->medicins()->attach($medicine->id,['quantity'=>$item['quantity']]);
            $medicin[]=$medicine;
         }
        else{
            $cart->delete();
            return $this->sendError('', ['error' => 'Medicine is not availlable'],500);
        }

        }
        return $this->sendResponse($medicin, "Done");

    }


    ___________________________________________________________




    public function ShowOrders()
    {

        $user_id = Auth::id();
        if (!$user_id) {
            return $this->sendError('', ['error' => 'please make sure that you have loggedin'],401);
        }
        $user=User::find($user_id);
        $orders = $user->orders()->orderBy("created_at","DESC")->select('id','status','paymentStatus')->get();
        return $this->sendResponse($orders, "Done");

    }

        ___________________________________________________________


        public function UpdateOrderStatus($id,Request $request){
        $admin=Auth::user();

        if($admin->role=='admin'){
        try{
            DB::beginTransaction(); /// start tramsaction
           $record = Cart::find($id);
           if(!$record){
            return $this->sendError('', ['error' => 'please try again later']);
           }
           $record->update($request->only(['status']));

           if ($request->status=='Reseved') {
            $record->update(['paymentStatus'=>'payed']);
               $order_medecins=$record->medicins;

               foreach ($order_medecins as $medicin){
                   $new_quantity=$medicin->quantity-$medicin->pivot->quantity;
                   if($new_quantity<0){
                    return $this->sendError('', ['error' => 'One medication is not enough for you have in the warehouse'],500);
                   }
                   $new_medicin=Medicin::find($medicin->id);
                   $new_medicin->update(['quantity' => $new_quantity]);
                   $new_medicin->save();
                }
           }
            DB::commit(); /// sava editings
            return $this->sendResponse([$record],"Done Successfully");
        }catch(\Exception $ex){
            DB::rollBack(); /// go back and return  error message
            return $this->sendError('', ['error' => 'please try again later']);
        }
    }
    return $this->sendError('', ['error' => 'You are not authorized to update of the order']);
 }

 */
