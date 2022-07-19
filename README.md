# Screenshot

<img src="screenshots/home.png" />

# Introduction
<p>Company profie website will generally include : </p>
<ul>
    <li>Be able to answer customers’ inquiries about your business.</li>
    <li>Briefly describe the operations and focus of your business.</li>
    <li>Include are product descriptions, pricing plans, and testimonials.</li>
    <li>Provide contact details or some way for customers to contact your business online directly.</li>
    <li>Offer insights into anything your customers might want to know.</li>
    <li>Include testimonials from former clients and employers to show your skills and expertise</li>
    <li>Offer links to your social media accounts so future clients and recruiters can get a fuller idea of your personality and get in touch with you easier</li>
    <li>Feature a home page, a contact page, and a product or service page</li>
    <li>User compelling content that encourages users to buy into the product or service </li>
</ul>

<br/>

# Minimum Requirements
<ul>
    <li>PHP 7.2 +</li>
    <li>Composer 2+</li>
    <li>Node JS 14+ </li>
    <li>MySQL 5/8+</li>
    <li>Git</li>
    <li>Modern Web Browser.</li>
    <li>Visual Studio Code or Sublime Text for editor.</li>
</ul>
<br/>

# How To Install
<br/>
<br/>
<strong>Clone this repository using command <em>git clone https://github.com/sanz404/webapp-company-profile-lumen.git</em></strong>

<br/>
<br/>
<br/>
<strong>Backend</strong>
<ul>
    <li>Make sure <em><strong>PHP 7.2+ , Composer 2+ and MySQL 5/8+</strong></em> installed in your computer.</li>
    <li>Move to backend directory and open command line then run script <em><strong>composer update</strong></em>.</li>
    <li>Make file .env in root backend directory, copy all variable from env.example.</li>
    <li>In .env file, please fill all empty configuration variable such as database connection, email and frontend URL.</li>
    <li>Please run 
        <ul>
            <li><em><strong>php artisan jwt:secret</strong></em></li>
            <li><em><strong>php artisan migrate</strong></em></li>
            <li><em><strong>php artisan db:seed</strong></em></li>
            <li><em><strong>php -S 127.0.0.1:8000 -t public</strong></em></li>
        </ul>
    </li>
</ul>

<br/>

<strong>Frontend</strong>
<ul>
    <li>Move to frontend directory and open command line.</li>
    <li>Please run <em><strong>npm install</strong> and then <strong>npm run serve</strong></em>.</li>
    <li>Open your web browser with address <em><strong>localhost:8080</strong></em>.</li>
    <li>Login with user admin : <em><strong>Email : admin@devel.com, Password : 5ecReT!</strong></em></li>
</ul>