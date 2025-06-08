<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Welcome Email</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, sans-serif;">
  <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4; padding: 30px 0;">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
          <tr>
            <td style="padding: 30px; text-align: center;">
              <h2 style="color: #333333; font-size: 24px; margin-bottom: 20px;">Welcome, {{ $user->name }}!</h2>
              <p style="color: #555555; font-size: 16px; margin-bottom: 20px;">
                Thank you for registering to our <strong>Inventory Management System</strong>.
              </p>
              <p style="color: #555555; font-size: 16px; margin-bottom: 30px;">
                You can now <a href="{{ url('/dashboard') }}" style="color: #1d4ed8; text-decoration: none;">access your dashboard</a> and start managing your items.
              </p>
              <a href="{{ url('/dashboard') }}" style="display: inline-block; padding: 12px 24px; background-color: #1d4ed8; color: #ffffff; text-decoration: none; border-radius: 6px; font-size: 16px;">
                Go to Dashboard
              </a>
              <p style="color: #777777; font-size: 14px; margin-top: 30px;">
                If you have any questions, feel free to reply to this email.
              </p>
              <hr style="margin: 40px 0; border: none; border-top: 1px solid #eeeeee;">
              <p style="color: #999999; font-size: 14px;">
                Best regards,<br>
                <strong>Inventory Management System Team</strong>
              </p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
