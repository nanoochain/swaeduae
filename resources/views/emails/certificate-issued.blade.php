<p>Dear {{ $certificate->registration->volunteer->user->name }},</p>
<p>Your certificate for the event <strong>{{ $certificate->registration->event->title }}</strong> has been issued.</p>
<p><a href="{{ url('storage/' . str_replace('public/', '', $certificate->file_path)) }}">Download your certificate</a></p>
<p>Thank you for volunteering!</p>
