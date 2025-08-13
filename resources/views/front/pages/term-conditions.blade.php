@extends('front.layout.pages-layout')
@section('pageTitle', $pageTitle ?? 'Terms and Conditions')
@section('meta_tags')
    {!! SEO::generate(true) !!}
@endsection
@section('content')
    <div class="container">
        <h2 class="mb-4 title-color">Terms and Conditions 📜</h2>

        <p>Last updated: July 27, 2025</p>

        <h4>1. Introduction</h4>
        <p>Welcome to <strong>{{ config('app.name') }}</strong>. These Terms and Conditions outline the rules and
            regulations for using our website and accessing its content.</p>

        <h4>2. Intellectual Property Rights</h4>
        <p>Unless otherwise stated, <strong>{{ config('app.name') }}</strong> and/or its licensors own the intellectual
            property rights for all material published on this website. All rights are reserved. You may access this content
            for personal use only, subject to the restrictions set in these terms.</p>

        <h4>3. Restrictions</h4>
        <p>You are specifically restricted from the following:</p>
        <ul>
            <li>Republishing material from this website on any other media;</li>
            <li>Selling, sublicensing, or commercializing any site content;</li>
            <li>Publicly performing or showing website material without permission;</li>
            <li>Using the website in a manner that is damaging to the site or its users;</li>
            <li>Engaging in unauthorized data collection or data scraping;</li>
            <li>Using the website in violation of applicable laws and regulations.</li>
        </ul>

        <h4>4. Your Content</h4>
        <p>By submitting content (e.g., comments or contributions), you grant <strong>{{ config('app.name') }}</strong> a
            non-exclusive, royalty-free, worldwide license to use, reproduce, and display such content. You are responsible
            for ensuring your content does not infringe on any third-party rights.</p>

        <h4>5. Limitation of Liability</h4>
        <p><strong>{{ config('app.name') }}</strong> and its team shall not be held liable for any indirect or consequential
            damages resulting from your use of this website. All content is provided "as-is" without warranties of any kind.
        </p>

        <h4>6. Indemnification</h4>
        <p>You agree to indemnify and hold harmless <strong>{{ config('app.name') }}</strong> and its affiliates from any
            claims, liabilities, losses, or expenses arising from your use of the website or violation of these Terms.</p>

        <h4>7. Modifications</h4>
        <p>We reserve the right to modify or replace these Terms at any time. Changes will be effective immediately upon
            being posted on this page. Continued use of the website after changes constitutes acceptance.</p>

        <h4>8. Governing Law &amp; Jurisdiction</h4>
        <p>These Terms are governed by and interpreted in accordance with the laws of <strong>Sri Lanka</strong>. You agree
            to submit to the jurisdiction of the courts located in <strong>Colombo</strong> for any disputes arising out of
            these terms.</p>
        <hr>
        <p class="text-muted">
            If you have any questions about these Terms, please contact us at
            <a href="mailto:{{ config('app.contact_email') }}">{{ config('app.contact_email') }}</a>.
        </p>
    </div>
@endsection
