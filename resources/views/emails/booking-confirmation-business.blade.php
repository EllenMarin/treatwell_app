<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Booking Received</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #059669; color: white; padding: 20px; text-align: center; }
        .content { background-color: #f9f9f9; padding: 20px; }
        .booking-details { background-color: white; padding: 15px; margin: 15px 0; border-left: 4px solid #059669; }
        .booking-details h3 { margin-top: 0; color: #059669; }
        .detail-row { margin: 10px 0; }
        .detail-label { font-weight: bold; display: inline-block; width: 150px; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
        .status-badge { display: inline-block; padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: bold; }
        .status-pending { background-color: #FEF3C7; color: #92400E; }
        .action-button { display: inline-block; padding: 10px 20px; background-color: #059669; color: white; text-decoration: none; border-radius: 4px; margin: 10px 5px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Booking Received</h1>
        </div>
        
        <div class="content">
            <p>Hello {{ $booking->business->name }},</p>
            
            <p>You have received a new booking request. Please review and confirm the booking as soon as possible.</p>
            
            <div class="booking-details">
                <h3>Booking Details</h3>
                
                <div class="detail-row">
                    <span class="detail-label">Service:</span>
                    <span>{{ $booking->plan->name }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Date:</span>
                    <span>{{ $booking->booking_date->format('l, F j, Y') }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Time:</span>
                    <span>{{ $booking->booking_time->format('g:i A') }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Duration:</span>
                    <span>{{ $booking->plan->formatted_duration }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Price:</span>
                    <span>{{ $booking->plan->formatted_price }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="status-badge status-pending">{{ ucfirst($booking->status) }}</span>
                </div>
                
                @if($booking->notes)
                <div class="detail-row">
                    <span class="detail-label">Customer Notes:</span>
                    <span>{{ $booking->notes }}</span>
                </div>
                @endif
            </div>
            
            <div class="booking-details">
                <h3>Customer Information</h3>
                
                <div class="detail-row">
                    <span class="detail-label">Name:</span>
                    <span>{{ $booking->customer_name }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span>{{ $booking->customer_email }}</span>
                </div>
                
                @if($booking->customer_phone)
                <div class="detail-row">
                    <span class="detail-label">Phone:</span>
                    <span>{{ $booking->customer_phone }}</span>
                </div>
                @endif
            </div>
            
            <p style="text-align: center;">
                <a href="{{ route('business.bookings.index') }}" class="action-button">View All Bookings</a>
            </p>
            
            <p><strong>Action Required:</strong></p>
            <ul>
                <li>Log in to your dashboard to confirm or modify this booking</li>
                <li>Contact the customer if you need to reschedule</li>
                <li>Ensure you have availability for this appointment</li>
            </ul>
        </div>
        
        <div class="footer">
            <p>This is an automated message. Please do not reply to this email.</p>
            <p>&copy; {{ date('Y') }} Treatwell Clone. All rights reserved.</p>
        </div>
    </div>
</body>
</html>

