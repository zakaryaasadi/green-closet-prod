<?php

namespace Database\Seeders;

use App\Enums\MessageType;
use App\Models\Country;
use App\Models\Language;
use App\Models\Message;
use Illuminate\Database\Seeder;

class MessageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Country
        $UAE = Country::whereCode('AE')->first()->id;
        $KSA = Country::whereCode('SA')->first()->id;
        $KW = Country::whereCode('KW')->first()->id;
        //Language
        $EN = Language::whereCode('en')->first()->id;
        $AR = Language::whereCode('ar')->first()->id;

        //Accept Order
        $this->createMessage('Hello $CLIENT_NAME your order #$ORDER_ID has been accepted', $UAE, MessageType::ACCEPT_ORDER_MESSAGE, $EN);

        $this->createMessage('مرحبا $CLIENT_NAME طلبك ذو الرقم #$ORDER_ID تم قبوله', $UAE, MessageType::ACCEPT_ORDER_MESSAGE, $AR);

        $this->createMessage('HI $CLIENT_NAME your order #$ORDER_ID has been accepted', $KSA, MessageType::ACCEPT_ORDER_MESSAGE, $EN);

        $this->createMessage('اهلا $CLIENT_NAME طلبك ذو الرقم #$ORDER_ID تم قبوله', $KSA, MessageType::ACCEPT_ORDER_MESSAGE, $AR);

        $this->createMessage('Whats up $CLIENT_NAME your order #$ORDER_ID has been accepted', $KW, MessageType::ACCEPT_ORDER_MESSAGE, $EN);

        $this->createMessage('كيف حالك $CLIENT_NAME طلبك ذو الرقم #$ORDER_ID تم قبوله', $KW, MessageType::ACCEPT_ORDER_MESSAGE, $AR);


        //Accept Order Title
        $this->createMessage('Hello $CLIENT_NAME Your order accepted', $UAE, MessageType::ACCEPT_ORDER_MESSAGE_TITLE, $EN);

        $this->createMessage('مرحبا $CLIENT_NAME طلبك ذو الرقم #$ORDER_ID تم قبوله', $UAE, MessageType::ACCEPT_ORDER_MESSAGE_TITLE, $AR);

        $this->createMessage('Hello $CLIENT_NAME Your order accepted', $KSA, MessageType::ACCEPT_ORDER_MESSAGE_TITLE, $EN);

        $this->createMessage('اهلا $CLIENT_NAME طلبك ذو الرقم #$ORDER_ID تم قبوله', $KSA, MessageType::ACCEPT_ORDER_MESSAGE_TITLE, $AR);

        $this->createMessage('Hello $CLIENT_NAME Your order accepted', $KW, MessageType::ACCEPT_ORDER_MESSAGE_TITLE, $EN);

        $this->createMessage('كيف حالك $CLIENT_NAME طلبك ذو الرقم #$ORDER_ID تم قبوله', $KW, MessageType::ACCEPT_ORDER_MESSAGE_TITLE, $AR);


        //Create Order
        $this->createMessage('Thanks $CLIENT_NAME your order is created', $UAE, MessageType::CREATE_ORDER_MESSAGE, $EN);

        $this->createMessage('شكرا $CLIENT_NAME لقد تم انشاء طلبك بنجاح', $UAE, MessageType::CREATE_ORDER_MESSAGE, $AR);

        $this->createMessage('Hello $CLIENT_NAME your order is created', $KSA, MessageType::CREATE_ORDER_MESSAGE, $EN);

        $this->createMessage('مرحبا $CLIENT_NAME لقد تم انشاء طلبك', $KSA, MessageType::CREATE_ORDER_MESSAGE, $AR);

        $this->createMessage('$CLIENT_NAME ! your order is created', $KW, MessageType::CREATE_ORDER_MESSAGE, $EN);

        $this->createMessage('$CLIENT_NAME ! لقد تم انشاء طلبك بنجاح', $KW, MessageType::CREATE_ORDER_MESSAGE, $AR);

        //Create Order Title
        $this->createMessage('Order is created', $UAE, MessageType::CREATE_ORDER_MESSAGE_TITLE, $EN);

        $this->createMessage('لقد تم انشاء طلبك بنجاح', $UAE, MessageType::CREATE_ORDER_MESSAGE_TITLE, $AR);

        $this->createMessage('Order is created', $KSA, MessageType::CREATE_ORDER_MESSAGE_TITLE, $EN);

        $this->createMessage('مرحبا لقد تم انشاء طلبك', $KSA, MessageType::CREATE_ORDER_MESSAGE_TITLE, $AR);

        $this->createMessage('Order is created', $KW, MessageType::CREATE_ORDER_MESSAGE_TITLE, $EN);

        $this->createMessage('لقد تم انشاء طلبك بنجاح!', $KW, MessageType::CREATE_ORDER_MESSAGE_TITLE, $AR);

        //Assign Order
        $this->createMessage('$CLIENT_NAME your order #$ORDER_ID is assign ', $UAE, MessageType::ASSIGNED_ORDER_MESSAGE, $EN);

        $this->createMessage('$CLIENT_NAME طلبك ذو الرقم $ORDER_ID فعال', $UAE, MessageType::ASSIGNED_ORDER_MESSAGE, $AR);

        $this->createMessage('$CLIENT_NAME your order #$ORDER_ID is assign', $KSA, MessageType::ASSIGNED_ORDER_MESSAGE, $EN);

        $this->createMessage('$CLIENT_NAME طلبك ذو الرقم $ORDER_ID فعال', $KSA, MessageType::ASSIGNED_ORDER_MESSAGE, $AR);

        $this->createMessage('$CLIENT_NAME your order #$ORDER_ID is assign', $KW, MessageType::ASSIGNED_ORDER_MESSAGE, $EN);

        $this->createMessage('$CLIENT_NAME طلبك ذو الرقم $ORDER_ID فعال', $KW, MessageType::ASSIGNED_ORDER_MESSAGE, $AR);

        //Assign Order Title
        $this->createMessage('The order is assigned', $UAE, MessageType::ASSIGNED_ORDER_MESSAGE_TITLE, $EN);

        $this->createMessage('تم اسناد الطلب', $UAE, MessageType::ASSIGNED_ORDER_MESSAGE_TITLE, $AR);

        $this->createMessage('The order is assigned', $KSA, MessageType::ASSIGNED_ORDER_MESSAGE_TITLE, $EN);

        $this->createMessage('تم اسناد الطلب', $KSA, MessageType::ASSIGNED_ORDER_MESSAGE_TITLE, $AR);

        $this->createMessage('The order is assigned', $KW, MessageType::ASSIGNED_ORDER_MESSAGE_TITLE, $EN);

        $this->createMessage('تم اسناد الطلب', $KW, MessageType::ASSIGNED_ORDER_MESSAGE_TITLE, $AR);


        //Assign Order Agent
        $this->createMessage('$ORDER_AGENT order #$ORDER_ID is assign to you', $UAE, MessageType::ASSIGNED_ORDER_MESSAGE_AGENT, $EN);

        $this->createMessage('$ORDER_AGENT الطلب ذو الرقم $ORDER_ID اسند اليك', $UAE, MessageType::ASSIGNED_ORDER_MESSAGE_AGENT, $AR);

        $this->createMessage('$ORDER_AGENT order #$ORDER_ID is assign to you', $KSA, MessageType::ASSIGNED_ORDER_MESSAGE_AGENT, $EN);

        $this->createMessage('$ORDER_AGENT الطلب ذو الرقم $ORDER_ID اسند اليك', $KSA, MessageType::ASSIGNED_ORDER_MESSAGE_AGENT, $AR);

        $this->createMessage('$ORDER_AGENT order #$ORDER_ID is assign to you', $KW, MessageType::ASSIGNED_ORDER_MESSAGE_AGENT, $EN);

        $this->createMessage('$ORDER_AGENT الطلب ذو الرقم $ORDER_ID اسند اليك', $KW, MessageType::ASSIGNED_ORDER_MESSAGE_AGENT, $AR);


        //Delivering Order
        $this->createMessage('$ORDER_AGENT is on the way to you', $UAE, MessageType::DELIVERING_ORDER_MESSAGE, $EN);

        $this->createMessage('$ORDER_AGENT في طريقه اليك!', $UAE, MessageType::DELIVERING_ORDER_MESSAGE, $AR);

        $this->createMessage('$ORDER_AGENT is on the way to you', $KSA, MessageType::DELIVERING_ORDER_MESSAGE, $EN);

        $this->createMessage('$ORDER_AGENT في طريقه اليك!', $KSA, MessageType::DELIVERING_ORDER_MESSAGE, $AR);

        $this->createMessage('$ORDER_AGENT is on the way to you', $KW, MessageType::DELIVERING_ORDER_MESSAGE, $EN);

        $this->createMessage('$ORDER_AGENT في طريقه اليك!', $KW, MessageType::DELIVERING_ORDER_MESSAGE, $AR);

        //Delivering Order Title
        $this->createMessage('Order is on the way to you', $UAE, MessageType::DELIVERING_ORDER_MESSAGE_TITLE, $EN);

        $this->createMessage('طلبك في طريقه اليك!', $UAE, MessageType::DELIVERING_ORDER_MESSAGE_TITLE, $AR);

        $this->createMessage('Order is on the way to you', $KSA, MessageType::DELIVERING_ORDER_MESSAGE_TITLE, $EN);

        $this->createMessage('طلبك في طريقه اليك!', $KSA, MessageType::DELIVERING_ORDER_MESSAGE_TITLE, $AR);

        $this->createMessage('Order is on the way to you', $KW, MessageType::DELIVERING_ORDER_MESSAGE_TITLE, $EN);

        $this->createMessage('طلبك في طريقه اليك!', $KW, MessageType::DELIVERING_ORDER_MESSAGE_TITLE, $AR);

        //Decline Order
        $this->createMessage('$CLIENT_NAME your order is Decline :(', $UAE, MessageType::DECLINE_ORDER_MESSAGE, $EN);

        $this->createMessage('$CLIENT_NAME طلبك تم رفضه', $UAE, MessageType::DECLINE_ORDER_MESSAGE, $AR);

        $this->createMessage('$CLIENT_NAME your order is Decline :(', $KSA, MessageType::DECLINE_ORDER_MESSAGE, $EN);

        $this->createMessage('$CLIENT_NAME طلبك تم رفضه', $KSA, MessageType::DECLINE_ORDER_MESSAGE, $AR);

        $this->createMessage('$CLIENT_NAME your order is Decline :(', $KW, MessageType::DECLINE_ORDER_MESSAGE, $EN);

        $this->createMessage('$CLIENT_NAME طلبك تم رفضه', $KW, MessageType::DECLINE_ORDER_MESSAGE, $AR);

        //Decline Order Title
        $this->createMessage('Order is Decline :(', $UAE, MessageType::DECLINE_ORDER_MESSAGE_TITLE, $EN);

        $this->createMessage('طلبك تم رفضه', $UAE, MessageType::DECLINE_ORDER_MESSAGE_TITLE, $AR);

        $this->createMessage('Order is Decline :(', $KSA, MessageType::DECLINE_ORDER_MESSAGE_TITLE, $EN);

        $this->createMessage('طلبك تم رفضه', $KSA, MessageType::DECLINE_ORDER_MESSAGE_TITLE, $AR);

        $this->createMessage('Order is Decline :(', $KW, MessageType::DECLINE_ORDER_MESSAGE_TITLE, $EN);

        $this->createMessage('طلبك تم رفضه', $KW, MessageType::DECLINE_ORDER_MESSAGE_TITLE, $AR);


        //Cancel Order
        $this->createMessage('$CLIENT_NAME your order is cancel :(', $UAE, MessageType::CANCEL_ORDER_MESSAGE, $EN);

        $this->createMessage('$CLIENT_NAME طلبك تم رفضه', $UAE, MessageType::CANCEL_ORDER_MESSAGE, $AR);

        $this->createMessage('$CLIENT_NAME your order is cancel :(', $KSA, MessageType::CANCEL_ORDER_MESSAGE, $EN);

        $this->createMessage('$CLIENT_NAME طلبك تم رفضه', $KSA, MessageType::CANCEL_ORDER_MESSAGE, $AR);

        $this->createMessage('$CLIENT_NAME your order is cancel :(', $KW, MessageType::CANCEL_ORDER_MESSAGE, $EN);

        $this->createMessage('$CLIENT_NAME طلبك تم رفضه', $KW, MessageType::CANCEL_ORDER_MESSAGE, $AR);

        //Cancel Order Title
        $this->createMessage('Order is cancel :(', $UAE, MessageType::CANCEL_ORDER_MESSAGE_TITLE, $EN);

        $this->createMessage('طلبك تم رفضه', $UAE, MessageType::CANCEL_ORDER_MESSAGE_TITLE, $AR);

        $this->createMessage('Order is cancel :(', $KSA, MessageType::CANCEL_ORDER_MESSAGE_TITLE, $EN);

        $this->createMessage('طلبك تم رفضه', $KSA, MessageType::CANCEL_ORDER_MESSAGE_TITLE, $AR);

        $this->createMessage('Order is cancel :(', $KW, MessageType::CANCEL_ORDER_MESSAGE_TITLE, $EN);

        $this->createMessage('طلبك تم رفضه', $KW, MessageType::CANCEL_ORDER_MESSAGE_TITLE, $AR);

        //Failed Order
        $this->createMessage('$CLIENT_NAME Order is failed :(', $UAE, MessageType::FAILED_ORDER_MESSAGE, $EN);

        $this->createMessage('$CLIENT_NAME طلبك قد فشل', $UAE, MessageType::FAILED_ORDER_MESSAGE, $AR);

        $this->createMessage('$CLIENT_NAME Order is failed :(', $KSA, MessageType::FAILED_ORDER_MESSAGE, $EN);

        $this->createMessage('$CLIENT_NAME طلبك قد فشل', $KSA, MessageType::FAILED_ORDER_MESSAGE, $AR);

        $this->createMessage('$CLIENT_NAME Order is failed :(', $KW, MessageType::FAILED_ORDER_MESSAGE, $EN);

        $this->createMessage('$CLIENT_NAME طلبك قد فشل', $KW, MessageType::FAILED_ORDER_MESSAGE, $AR);

        //Failed Order Title
        $this->createMessage('Order failed :(', $UAE, MessageType::FAILED_ORDER_MESSAGE_TITLE, $EN);

        $this->createMessage('طلبك قد فشل', $UAE, MessageType::FAILED_ORDER_MESSAGE_TITLE, $AR);

        $this->createMessage('Order is failed :(', $KSA, MessageType::FAILED_ORDER_MESSAGE_TITLE, $EN);

        $this->createMessage('طلبك قد فشل', $KSA, MessageType::FAILED_ORDER_MESSAGE_TITLE, $AR);

        $this->createMessage('Order is failed :(', $KW, MessageType::FAILED_ORDER_MESSAGE_TITLE, $EN);

        $this->createMessage('طلبك قد فشل', $KW, MessageType::FAILED_ORDER_MESSAGE_TITLE, $AR);

        //Successful Order
        $this->createMessage('Thanks for save the environment $CLIENT_NAME ! you order #$ORDER_ID is completed', $UAE, MessageType::SUCCESSFUL_ORDER_MESSAGE, $EN);

        $this->createMessage('شكرا $CLIENT_NAME على انقاذك للبيئة! طلبك ذو الرقم $ORDER_ID قد اكتمل', $UAE, MessageType::SUCCESSFUL_ORDER_MESSAGE, $AR);

        $this->createMessage('Thanks for save the environment $CLIENT_NAME ! you order #$ORDER_ID is completed', $KSA, MessageType::SUCCESSFUL_ORDER_MESSAGE, $EN);

        $this->createMessage('شكرا $CLIENT_NAME على انقاذك للبيئة! طلبك ذو الرقم $ORDER_ID قد اكتمل', $KSA, MessageType::SUCCESSFUL_ORDER_MESSAGE, $AR);

        $this->createMessage('Thanks for save the environment $CLIENT_NAME ! you order #$ORDER_ID is completed', $KW, MessageType::SUCCESSFUL_ORDER_MESSAGE, $EN);

        $this->createMessage('شكرا $CLIENT_NAME على انقاذك للبيئة! طلبك ذو الرقم $ORDER_ID قد اكتمل', $KW, MessageType::SUCCESSFUL_ORDER_MESSAGE, $AR);


        //Successful Order Title
        $this->createMessage('Order is completed', $UAE, MessageType::SUCCESSFUL_ORDER_MESSAGE_TITLE, $EN);

        $this->createMessage('طلبك قد اكتمل', $UAE, MessageType::SUCCESSFUL_ORDER_MESSAGE_TITLE, $AR);

        $this->createMessage('Order is completed', $KSA, MessageType::SUCCESSFUL_ORDER_MESSAGE_TITLE, $EN);

        $this->createMessage('طلبك قد اكتمل', $KSA, MessageType::SUCCESSFUL_ORDER_MESSAGE_TITLE, $AR);

        $this->createMessage('Order is completed', $KW, MessageType::SUCCESSFUL_ORDER_MESSAGE_TITLE, $EN);

        $this->createMessage('طلبك قد اكتمل', $KW, MessageType::SUCCESSFUL_ORDER_MESSAGE_TITLE, $AR);


        //Thanks message
        $this->createMessage('Thanks for your effort! your order is created', $UAE, MessageType::THANKS_MESSAGE, $EN);

        $this->createMessage('تم انشاء طلبك بنجاح!
        سيتصل بك احد ممثلينا باقرب وقت ممكن!', $UAE, MessageType::THANKS_MESSAGE, $AR);

        $this->createMessage('Thanks for your effort! your order is created', $KSA, MessageType::THANKS_MESSAGE, $EN);

        $this->createMessage('تم انشاء طلبك بنجاح!
        سيتصل بك احد ممثلينا باقرب وقت ممكن!', $KSA, MessageType::THANKS_MESSAGE, $AR);

        $this->createMessage('Thanks for your effort! your order is created', $KW, MessageType::THANKS_MESSAGE, $EN);

        $this->createMessage('تم انشاء طلبك بنجاح!
        سيتصل بك احد ممثلينا باقرب وقت ممكن!', $KW, MessageType::THANKS_MESSAGE, $AR);


        $this->createMessage('العميل غير جاهز الآن Another Day', $UAE, MessageType::FAILED_MESSAGE, $EN);
        $this->createMessage('العميل لا يرد  No Answer', $UAE, MessageType::FAILED_MESSAGE, $EN);
        $this->createMessage('جوال العميل مغلق  Switch off phone', $UAE, MessageType::FAILED_MESSAGE, $EN);
        $this->createMessage('الموقع خاطئ  Location Wrong', $UAE, MessageType::FAILED_MESSAGE, $EN);
        $this->createMessage('الرقم غير صحيح  Wrong Number', $UAE, MessageType::FAILED_MESSAGE, $EN);

        $this->createMessage('العميل غير جاهز الآن Another Day', $KW, MessageType::FAILED_MESSAGE, $EN);
        $this->createMessage('العميل لا يرد  No Answer', $KW, MessageType::FAILED_MESSAGE, $EN);
        $this->createMessage('جوال العميل مغلق  Switch off phone', $KW, MessageType::FAILED_MESSAGE, $EN);
        $this->createMessage('الموقع خاطئ  Location Wrong', $KW, MessageType::FAILED_MESSAGE, $EN);
        $this->createMessage('الرقم غير صحيح  Wrong Number', $KW, MessageType::FAILED_MESSAGE, $EN);

        $this->createMessage('العميل غير جاهز الآن Another Day', $KSA, MessageType::FAILED_MESSAGE, $EN);
        $this->createMessage('العميل لا يرد  No Answer', $KSA, MessageType::FAILED_MESSAGE, $EN);
        $this->createMessage('جوال العميل مغلق  Switch off phone', $KSA, MessageType::FAILED_MESSAGE, $EN);
        $this->createMessage('الموقع خاطئ  Location Wrong', $KSA, MessageType::FAILED_MESSAGE, $EN);
        $this->createMessage('الرقم غير صحيح  Wrong Number', $KSA, MessageType::FAILED_MESSAGE, $EN);


        //Expense Created Title
        $this->createMessage('$ASSOCIATION_NAME is request expense $EXPENSE_ID', $KSA, MessageType::ASSOCIATION_EXPENSES_REQUESTED_TITLE, $EN);
        $this->createMessage('$ASSOCIATION_NAME طلب سحب رصيد $EXPENSE_ID', $KSA, MessageType::ASSOCIATION_EXPENSES_REQUESTED_TITLE, $AR);
        $this->createMessage('$ASSOCIATION_NAME is request expense $EXPENSE_ID', $UAE, MessageType::ASSOCIATION_EXPENSES_REQUESTED_TITLE, $EN);
        $this->createMessage('$ASSOCIATION_NAME طلب سحب رصيد $EXPENSE_ID', $UAE, MessageType::ASSOCIATION_EXPENSES_REQUESTED_TITLE, $AR);
        $this->createMessage('$ASSOCIATION_NAME is request expense $EXPENSE_ID', $KW, MessageType::ASSOCIATION_EXPENSES_REQUESTED_TITLE, $EN);
        $this->createMessage('$ASSOCIATION_NAME طلب سحب رصيد $EXPENSE_ID', $KW, MessageType::ASSOCIATION_EXPENSES_REQUESTED_TITLE, $AR);


        //Expense Created Message
        $this->createMessage('$ASSOCIATION_NAME is request expense $EXPENSE_ID', $KSA, MessageType::ASSOCIATION_EXPENSES_REQUESTED_MESSAGE, $EN);
        $this->createMessage('$ASSOCIATION_NAME طلب سحب رصيد $EXPENSE_ID', $KSA, MessageType::ASSOCIATION_EXPENSES_REQUESTED_MESSAGE, $AR);
        $this->createMessage('$ASSOCIATION_NAME is request expense $EXPENSE_ID', $UAE, MessageType::ASSOCIATION_EXPENSES_REQUESTED_MESSAGE, $EN);
        $this->createMessage('$ASSOCIATION_NAME طلب سحب رصيد $EXPENSE_ID', $UAE, MessageType::ASSOCIATION_EXPENSES_REQUESTED_MESSAGE, $AR);
        $this->createMessage('$ASSOCIATION_NAME is request expense $EXPENSE_ID', $KW, MessageType::ASSOCIATION_EXPENSES_REQUESTED_MESSAGE, $EN);
        $this->createMessage('$ASSOCIATION_NAME طلب سحب رصيد $EXPENSE_ID', $KW, MessageType::ASSOCIATION_EXPENSES_REQUESTED_MESSAGE, $AR);


        $this->createMessage('Dear $CLIENT_NAME your order is success and your invoice in : ', $KSA, MessageType::INVOICE_MESSAGE, $EN);
        $this->createMessage('Dear $CLIENT_NAME your order is success and your invoice in : ', $KSA, MessageType::INVOICE_MESSAGE, $AR);

        $this->createMessage('Dear $CLIENT_NAME your order is success and your invoice in : ', $UAE, MessageType::INVOICE_MESSAGE, $EN);
        $this->createMessage('Dear $CLIENT_NAME your order is success and your invoice in : ', $UAE, MessageType::INVOICE_MESSAGE, $AR);

        $this->createMessage('Dear $CLIENT_NAME your order is success and your invoice in : ', $KW, MessageType::INVOICE_MESSAGE, $EN);
        $this->createMessage('Dear $CLIENT_NAME your order is success and your invoice in : ', $KW, MessageType::INVOICE_MESSAGE, $AR);
    }

    public static function createMessage($content, $country_id, $type, $language_id)
    {
        Message::create([
            'content' => $content,
            'country_id' => $country_id,
            'type' => $type,
            'language_id' => $language_id,
        ]);

    }
}
