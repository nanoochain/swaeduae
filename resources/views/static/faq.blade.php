@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-12">
    <h1 class="text-3xl font-bold mb-6">{{ __('messages.faq_title') ?? 'الأسئلة الشائعة' }}</h1>
    <div class="space-y-4">
        <div>
            <h2 class="font-semibold">{{ __('messages.faq_q1') ?? 'كيف أسجل في المنصة؟' }}</h2>
            <p>{{ __('messages.faq_a1') ?? 'يمكنك التسجيل من خلال الضغط على زر التسجيل وملء بياناتك.' }}</p>
        </div>
        <div>
            <h2 class="font-semibold">{{ __('messages.faq_q2') ?? 'كيف أحصل على شهادة تطوع؟' }}</h2>
            <p>{{ __('messages.faq_a2') ?? 'بعد الانتهاء من الفعالية، يمكنك طلب الشهادة من صفحة ملفك الشخصي.' }}</p>
        </div>
        <div>
            <h2 class="font-semibold">{{ __('messages.faq_q3') ?? 'كيف أتواصل مع الدعم الفني؟' }}</h2>
            <p>{{ __('messages.faq_a3') ?? 'استخدم نموذج التواصل على صفحة التواصل معنا لإرسال استفسارك.' }}</p>
        </div>
    </div>
</div>
@endsection
