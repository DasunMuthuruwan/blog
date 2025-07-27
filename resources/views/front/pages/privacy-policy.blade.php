@extends('front.layout.pages-layout')
@section('pageTitle', $pageTitle ?? 'Privacy Policy')
@section('meta_tags')
    {!! SEO::generate(true) !!}
@endsection
@section('content')
    <div class="container">
        <h2 class="mb-4 title-color">Privacy Policy 🔒</h2>
        <p>Last updated: July 27, 2025</p>

        <section class="mb-4">
            <h4>1. Introduction</h4>
            <p>Welcome to <strong>Your Website Name</strong>. Your privacy is important to us. This Privacy Policy explains
                how we collect, use, disclose, and safeguard your information when you visit our website.</p>
        </section>

        <section class="mb-4">
            <h4>2. Information We Collect 📋</h4>

            <h5>Personal Information 👤</h5>
            <p>We may collect personally identifiable information when you voluntarily submit it to us, such as:</p>
            <ul>
                <li>📧 dasunmuthuruwan9@gmail.com</li>
                <li>🧑 Dasun Muthuruwan</li>
                <li>📞 +94 (72) 9374928</li>
            </ul>

            <h5>Usage Information ⚙️</h5>
            <p>We automatically collect certain data when you access our website, including:</p>
            <ul>
                <li>🌐 IP address</li>
                <li>🖥️ Browser type and version</li>
                <li>📄 Pages visited and time spent on those pages</li>
                <li>🔗 Referring URLs</li>
            </ul>
        </section>

        <section class="mb-4">
            <h4>3. How We Use Your Information 🔍</h4>
            <p>We use your information to:</p>
            <ul>
                <li>🛠️ Operate and maintain our website</li>
                <li>🚀 Improve website functionality and performance</li>
                <li>💬 Respond to inquiries or provide customer support</li>
                <li>📢 Send you updates and promotional content, if subscribed</li>
                <li>📊 Monitor usage and detect technical issues</li>
            </ul>
        </section>

        <section class="mb-4">
            <h4>4. Sharing Your Information 🤝</h4>
            <p>We do not sell or rent your personal information. We may share your data with trusted third parties in the
                following cases:</p>
            <ul>
                <li>🔧 With service providers who help operate our website</li>
                <li>⚖️ When required by law, subpoena, or legal process</li>
                <li>🛡️ To protect and defend our rights or property</li>
            </ul>
        </section>

        <section class="mb-4">
            <h4>5. Security of Information 🔒</h4>
            <p>We implement industry-standard safeguards to protect your data. However, no method of transmission over the
                internet is completely secure, and we cannot guarantee absolute security.</p>
        </section>

        <section class="mb-4">
            <h4>6. Your Data Rights 🛡️</h4>
            <p>You may request access to or correction of your personal data. You also have the right to request deletion,
                subject to any legal obligations we may have to retain it.</p>
            <p>To exercise your rights, contact us at: <a
                    href="mailto:{{ settings()->site_email }}">{{ settings()->site_email }}</a> ✉️.</p>
        </section>

        <section class="mb-4">
            <h4>7. Third-Party Links 🔗</h4>
            <p>Our website may include links to third-party sites. We are not responsible for the content or privacy
                practices of those sites. Please review their privacy policies separately.</p>
        </section>

        <section class="mb-4">
            <h4>8. Policy Updates 🔄</h4>
            <p>We may update this Privacy Policy from time to time. Changes will be posted on this page, and the "Last
                updated" date will be revised accordingly. Please review this policy periodically.</p>
        </section>

        <section class="mb-4">
            <h4>9. Contact Us 📞</h4>
            <p>If you have any questions or concerns about this Privacy Policy, please reach out:</p>
            <ul>
                <li>Email: <a href="mailto:{{ settings()->site_email }}">{{ settings()->site_email }}</a> ✉️</li>
                <li>Phone: +94 (72) 9374928 📱</li>
            </ul>
        </section>

    </div>
@endsection
