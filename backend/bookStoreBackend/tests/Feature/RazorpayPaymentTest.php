<?php

namespace Tests\Feature;

use Tests\TestCase;

class RazorpayPaymentTest extends TestCase
{
    /**
     * Test that the checkout page renders successfully,
     * including dynamic integration with Razorpay SDK (order generation).
     */
    public function test_payment_page_can_be_rendered_successfully()
    {
        $response = $this->get('/payment');

        // Assert HTTP success status
        $response->assertStatus(200);
        
        // Assert correct view
        $response->assertViewIs('razorpay.payment');
        
        // Assert visual cues and branding are present
        $response->assertSee('BookVault');
        $response->assertSee('Complete Your Order');
        $response->assertSee('Pay Now');
        $response->assertSee('demouser@example.com');
        
        // Assert Razorpay dynamic properties are passed to view
        $response->assertViewHas('keyId');
        $response->assertViewHas('orderId');
        
        $orderId = $response->viewData('orderId');
        $this->assertNotEmpty($orderId);
        $this->assertStringStartsWith('order_', $orderId);
    }

    /**
     * Test that the payment callback rejects invalid signature payloads
     * and shows a beautiful, helpful error receipt view.
     */
    public function test_payment_callback_rejects_invalid_signature()
    {
        $response = $this->post('/payment/callback', [
            'razorpay_payment_id' => 'pay_invalid123456',
            'razorpay_order_id' => 'order_invalid123456',
            'razorpay_signature' => 'signature_invalid123456'
        ]);

        // Should return a response showing the error page
        $response->assertStatus(200);
        $response->assertViewIs('razorpay.error');
        $response->assertSee('Signature verification failed');
        $response->assertSee('Transaction could not be verified securely');
    }

    /**
     * Test that the payment callback returns the error view when parameters are missing.
     */
    public function test_payment_callback_rejects_missing_parameters()
    {
        $response = $this->post('/payment/callback', []);

        // Should return a response showing the parameter validation error page
        $response->assertStatus(200);
        $response->assertViewIs('razorpay.error');
        $response->assertSee('Payment failed, cancelled, or missing response parameters');
    }

    /**
     * Test that the API order creation endpoint rejects unauthenticated requests.
     */
    public function test_api_create_order_rejects_unauthenticated()
    {
        $response = $this->postJson('/api/razorpay/order', [
            'items' => []
        ]);

        $response->assertStatus(401);
    }

    /**
     * Test that the API payment verification endpoint rejects unauthenticated requests.
     */
    public function test_api_verify_payment_rejects_unauthenticated()
    {
        $response = $this->postJson('/api/razorpay/verify', [
            'razorpay_payment_id' => 'pay_123',
            'razorpay_order_id' => 'order_123',
            'razorpay_signature' => 'sig_123',
            'shipping_address' => 'Test Address',
            'items' => []
        ]);

        $response->assertStatus(401);
    }
}
