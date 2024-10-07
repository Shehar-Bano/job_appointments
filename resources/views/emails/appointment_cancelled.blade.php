<!DOCTYPE html>
<head>
    <title>Appointment Cancelled</title>
</head>
<body>
    <h1>Dear {{ $candidateName }},</h1>
    <p>We regret to inform you that your appointment scheduled for {{ $appointmentDate }} has been cancelled.</p>
    <p>Original Slot Timing: {{ $slotStartTime }} to {{ $slotEndTime }}</p>
    <p>If you have any questions, please do not hesitate to contact us.</p>
    <p>Thank you for your understanding.</p>
</body>
</html>
