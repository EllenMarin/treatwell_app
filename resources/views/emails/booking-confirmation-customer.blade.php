<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Confirmation</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #4F46E5; color: white; padding: 20px; text-align: center; }
        .content { background-color: #f9f9f9; padding: 20px; }
        .booking-details { background-color: white; padding: 15px; margin: 15px 0; border-left: 4px solid #4F46E5; }
        .booking-details h3 { margin-top: 0; color: #4F46E5; }
        .detail-row { margin: 10px 0; }
        .detail-label { font-weight: bold; display: inline-block; width: 150px; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
        .status-badge { display: inline-block; padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: bold; }
        .status-pending { background-color: #FEF3C7; color: #92400E; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Booking Confirmation</h1>
        </div>
        
        <div class="content">
            <p>Dear {{ $booking->customer_name }},</p>
            
            <p>Thank you for your booking! Your appointment has been received and is pending confirmation from the business.</p>
            
            <div class="booking-details">
                <h3>Booking Details</h3>
                
                <div class="detail-row">
                    <span class="detail-label">Business:</span>
                    <span>{{ $booking->business->name }}</span>
                </div>
                
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
                    <span class="detail-label">Notes:</span>
                    <span>{{ $booking->notes }}</span>
                </div>
                @endif
            </div>
            
            <div class="booking-details">
                <h3>Business Contact Information</h3>
                
                @if($booking->business->address)
                <div class="detail-row">
                    <span class="detail-label">Address:</span>
                    <span>{{ $booking->business->address }}, {{ $booking->business->city }} {{ $booking->business->postal_code }}</span>
                </div>
                @endif
                
                @if($booking->business->phone)
                <div class="detail-row">
                    <span class="detail-label">Phone:</span>
                    <span>{{ $booking->business->phone }}</span>
                </div>
                @endif
                
                @if($booking->business->email)
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span>{{ $booking->business->email }}</span>
                </div>
                @endif
            </div>
            
            <p><strong>What's Next?</strong></p>
            <ul>
                <li>The business will review and confirm your booking shortly</li>
                <li>You will receive another email once your booking is confirmed</li>
                <li>If you need to cancel or modify your booking, please contact the business directly</li>
            </ul>
        </div>
        
        <div class="footer">
            <p>This is an automated message. Please do not reply to this email.</p>
            <p>&copy; {{ date('Y') }} Treatwell Clone. All rights reserved.</p>
        </div>
    </div>
</body>
</html>

