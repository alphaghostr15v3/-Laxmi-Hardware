@extends('layouts.app')
@section('title', 'Privacy Policy — Laxmi Hardware')

@section('content')

<section style="padding:100px 0 64px;background:#000;text-align:center;position:relative;overflow:hidden;">
  <div style="position:absolute;top:-80px;left:50%;transform:translateX(-50%);width:700px;height:700px;background:radial-gradient(ellipse,rgba(201,169,110,0.07) 0%,transparent 70%);pointer-events:none;"></div>
  <div class="apple-container" style="position:relative;">
    <span class="apple-eyebrow reveal">Legal Information</span>
    <h1 class="apple-title reveal reveal--delay-1" style="max-width:600px;margin:12px auto 20px;">Privacy Policy</h1>
    <p class="apple-subtitle reveal reveal--delay-2" style="max-width:500px;margin:0 auto;">How we handle and protect your personal information.</p>
  </div>
</section>

<section class="apple-section apple-section--dark" style="padding-top:24px;padding-bottom:120px;">
  <div class="apple-container" style="max-width:800px;">
    <div style="background:#111;border:1px solid rgba(255,255,255,0.08);border-radius:20px;padding:48px;" class="reveal">
      <div style="color:#a1a1a6;font-size:16px;line-height:1.8;font-weight:300;">
        <h2 style="font-size:20px;font-weight:700;color:#f5f5f7;margin-top:0;margin-bottom:16px;">1. Introduction</h2>
        <p style="margin-bottom:24px;">Welcome to Laxmi Hardware. We respect your privacy and are committed to protecting your personal data. This privacy policy will inform you about how we look after your personal data when you visit our website (regardless of where you visit it from) and tell you about your privacy rights.</p>

        <h2 style="font-size:20px;font-weight:700;color:#f5f5f7;margin-top:32px;margin-bottom:16px;">2. The Data We Collect About You</h2>
        <p style="margin-bottom:16px;">We may collect, use, store and transfer different kinds of personal data about you which we have grouped together as follows:</p>
        <ul style="margin-bottom:24px;padding-left:20px;">
            <li style="margin-bottom:8px;"><strong>Identity Data</strong> includes first name, last name, username or similar identifier.</li>
            <li style="margin-bottom:8px;"><strong>Contact Data</strong> includes billing address, delivery address, email address and telephone numbers.</li>
            <li style="margin-bottom:8px;"><strong>Technical Data</strong> includes internet protocol (IP) address, browser type and version, time zone setting and location.</li>
            <li style="margin-bottom:8px;"><strong>Usage Data</strong> includes information about how you use our website, products and services.</li>
        </ul>

        <h2 style="font-size:20px;font-weight:700;color:#f5f5f7;margin-top:32px;margin-bottom:16px;">3. How We Use Your Personal Data</h2>
        <p style="margin-bottom:16px;">We will only use your personal data when the law allows us to. Most commonly, we will use your personal data in the following circumstances:</p>
        <ul style="margin-bottom:24px;padding-left:20px;">
            <li style="margin-bottom:8px;">Where we need to perform the contract we are about to enter into or have entered into with you.</li>
            <li style="margin-bottom:8px;">Where it is necessary for our legitimate interests (or those of a third party) and your interests and fundamental rights do not override those interests.</li>
            <li style="margin-bottom:8px;">Where we need to comply with a legal obligation.</li>
        </ul>

        <h2 style="font-size:20px;font-weight:700;color:#f5f5f7;margin-top:32px;margin-bottom:16px;">4. Data Security</h2>
        <p style="margin-bottom:24px;">We have put in place appropriate security measures to prevent your personal data from being accidentally lost, used or accessed in an unauthorised way, altered or disclosed. In addition, we limit access to your personal data to those employees, agents, contractors and other third parties who have a business need to know.</p>

        <h2 style="font-size:20px;font-weight:700;color:#f5f5f7;margin-top:32px;margin-bottom:16px;">5. Contact Details</h2>
        <p style="margin-bottom:24px;">If you have any questions about this privacy policy or our privacy practices, please contact us at:</p>
        <p style="margin-bottom:8px;"><strong>Laxmi Hardware</strong></p>
        <p style="margin-bottom:8px;">{{ \App\Models\Setting::get('address', 'Hardware Plaza, Ring Road, Surat, Gujarat 395002') }}</p>
        <p style="margin-bottom:8px;">Email: {{ \App\Models\Setting::get('email', 'info@laxmihardware.com') }}</p>
        <p style="margin-bottom:0;">Phone: {{ \App\Models\Setting::get('phone', '+91 98765 43210') }}</p>
      </div>
    </div>
  </div>
</section>

@endsection
