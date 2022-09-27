@extends('layouts.app')

@section('pagetitle', 'Merchant Bay | FAQ')
@section('title', 'Merchant Bay | FAQ')
@section('description', "Frequently Asked Questions about Merchant Bay answered. Ask Questions, get to know how to use Merchant Bay's Services")
@section('image', Storage::disk('s3')->url('public/frontendimages/FAQ.png'))
@section('keywords', 'Merchant Bay, Textile Industry, Textile Company, Apparel Industry, Garments Company, Garment Manufacturing, Textile Factory, Business clothing factory, Fashion Manufacturers, B2B platform, B2B fashion, Fashion e-commerce, B2B e-commerce, RMG e-commerce, Fabric e-commerce, YARN e-commerce, Marketplace, RMG Marketplace, Fashion, Fashion Sourching, Best Suppliers in Bangladesh, Bangladesh RMG Sourching, Apparel Sourcing, Garments in Bangladesh, Post RFQ, RMG RFQ, RMG, Bulk RMG, RFQ, RMG Sourching, 3D Design, 3D Fashion, Merchandiser, Suppliers, Request for quotation, Fabric, Fabric Sourcing, Fabric Marketplace, Fabric Suppliers, Fabric RFQ, Fabric Suppliers in Bangladesh, Bulk Fabric, YARN, YARN Sourcing, YARN Marketplace, YARN Suppliers, YARN RFQ, YARN Suppliers in Bangladesh, Bulk YARN, Live fashion market, Ready Stock, merchantbay.com')

@section('ogtitle', 'Merchant Bay | FAQ')
@section('ogdescription', "Frequently Asked Questions about Merchant Bay answered. Ask Questions, get to know how to use Merchant Bay's Services")
@section('ogimage', Storage::disk('s3')->url('public/frontendimages/FAQ.png'))

@section('robots', 'index, nofollow')

@section('content')

<div class="faq_contentinfo_wrapper">
    <div class="faq_search_wrap center-align">
        <h1>Frequently Asked Questions</h1>
        <label>Have questions? We're here to help.</label>
        <div class="faq_search_box">
            <i class="material-icons">search</i>
            <input type="text" placeholder="Search anything" class="faq_search_input typeahead tt-query" autocomplete="off" spellcheck="false">
            <a href="javascript:void(0);" class="reset_faq_filter" style="display: none;"><i class="material-icons">restart_alt</i></a>
        </div>
    </div>
    <div class="faq_infobox_wrap">
        <div class="tab">
            <div class="rfq_tab_item_box">
                <button class="tablinks triggerEvent active" onclick="faqCategory(event, 'faqCategoryAll')" id="defaultOpen">All</button>
                <button class="tablinks" onclick="faqCategory(event, 'faqCategoryWhat')">What</button>
                <button class="tablinks" onclick="faqCategory(event, 'faqCategoryHow')">How</button>
                <button class="tablinks" onclick="faqCategory(event, 'faqCategoryCan')">Can</button>
                <button class="tablinks" onclick="faqCategory(event, 'faqCategoryOthers')">Others</button>
            </div>
            <div class="faq_talkToUs_boxWrap center-align faq_talkToUs_boxWrap_desktop">
                <h3>Still have questions?</h3>
                <a href="javascript:void(0);" class="btn_green btn_talk" itemprop="Talk to us" onclick="Calendly.initPopupWidget({url: 'https://calendly.com/merchantbay/virtual-meeting'});return false;">Talk to us <i class="material-icons"> east </i></a>
            </div>
        </div>

        <div id="faqCategoryAll" class="tabcontent">
            <div class="faq_collaps_content">
                <div class="noFaqItemFound" style="display: none;">
                    <div class="card-alert card cyan lighten-5">
                        <div class="card-content cyan-text">
                            <p>No item found.</p>
                        </div>
                </div>
                </div>
                <ul class="collapsible data-title-filter">
                    <!-- What start -->
                    <li data-title="What is Merchant Bay Limited?">
                        <div class="collapsible-header">
                            <h4>What is Merchant Bay Limited?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Merchant Bay is an e-supply chain platform and SaaS provider for the readymade garment industry.</p>
                        </div>
                    </li>
                    <li data-title="What are the services Merchant Bay offers?">
                        <div class="collapsible-header">
                            <h4>What are the services Merchant Bay offers?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Merchant Bay offers an easy access point to Bangladesh RMG industry. From <a href="{{route('product.type.mapping',['studio', 'design'])}}">design</a>, product development and <a href="{{route('product.type.mapping',['raw_materials', 'textile'])}}">material sourcing</a>, Merchant Bay has it all in one place so that your sourcing experience become easy, transparent and traceable. </p>
                            <p>Merchant Bay does this by making Bangladesh's RMG supply chain visible. Supplier profiles are elaborate and made to increase trust and global reach. Manufacturers can also source raw materials and subscribe to <a href="https://accounts.merchantbay.com/login">Smart Order Management Dashboard</a> to increase their operational efficiency.</p>
                        </div>
                    </li>
                    <li data-title="What makes Merchant Bay unique?">
                        <div class="collapsible-header">
                            <h4>What makes Merchant Bay unique?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Merchant Bay is the only platform providing the easy and simple one click accesses to the Bangladesh RMG industry. You can bring your ideas into reality with Merchant Bay's vertically integrated RMG supply chain. </p>
                        </div>
                    </li>
                    <li data-title="What products can I buy from Merchant Bay?">
                        <div class="collapsible-header">
                            <h4>What products can I buy from Merchant Bay?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>You can source anything related to RMG manufacturing from Merchant Bay. We have a diverse product catalog ranging from <a href="{{route('product.type.mapping',['studio', 'design'])}}">design</a>, <a href="{{route('product.type.mapping',['raw_materials', 'textile'])}}">textile</a>, <a href="{{route('product.type.mapping',['raw_materials', 'yarn'])}}">yarn</a>, <a href="{{route('product.type.mapping',['raw_materials', 'trims and accessories'])}}">trims and accessories</a>.</p>
                        </div>
                    </li>
                    <li data-title="What is the price range for Merchant Bay's products?">
                        <div class="collapsible-header">
                            <h4>What is the price range for Merchant Bay's products?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Price largely depends on <a href="{{route('product.type.mapping',['studio', 'design'])}}">design</a> and volume. To get the price for your design send us a <a href="{{route('rfq.create')}}">Request for Quotation</a>.</p>
                        </div>
                    </li>
                    <li data-title="What if I need to modify a product, like I need to attach my logo in design?">
                        <div class="collapsible-header">
                            <h4>What if I need to modify a product, like I need to attach my logo in design?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>You can modify a design to your needs. You can also develop your own design with Merchant Bay <a href="{{route('product.type.mapping',['studio', 'design'])}}">Studio</a>.</p>
                        </div>
                    </li>
                    <li data-title="What to do if I don't find what I am looking for?">
                        <div class="collapsible-header">
                            <h4>What to do if I don't find what I am looking for?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Post an <a href="{{route('rfq.create')}}">RFQ</a> specifying your product. <a href="{{route('suppliers')}}">Suppliers</a> will develop your concept to <a href="{{route('product.type.mapping',['studio', 'design'])}}">design</a>.</p>
                        </div>
                    </li>
                    <li data-title="What is an RFQ?">
                        <div class="collapsible-header">
                            <h4>What is an RFQ?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Ans: <a href="{{route('rfq.create')}}">RFQ</a> is the system that enables Merchant Bay users to post the request and get matched <a href="{{route('suppliers')}}">suppliers</a> to source anything related to apparel in minimum time. Our matching system is 2x more efficient compared to traditional process. </p>
                        </div>
                    </li>
                    <li data-title="What to do if I don't receive any reply on my RFQ?">
                        <div class="collapsible-header">
                            <h4>What to do if I don't receive any reply on my RFQ?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Report a complaint or <a href="javascript:void(0);" itemprop="Talk to us" onclick="Calendly.initPopupWidget({url: 'https://calendly.com/merchantbay/virtual-meeting'});return false;">Contact</a> Merchant Bay, we will get in touch with you as soon as possible.</p>
                        </div>
                    </li>
                    <li data-title="What is a Smart Order Management Dashboard?">
                        <div class="collapsible-header">
                            <h4>What is a Smart Order Management Dashboard?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p><a href="https://omd.merchantbay.com/">Smart Order Management Dashboard</a> provides easy actionable data to help ease the burden of maintaining multiple orders. Smart OMD reduces order complexities and increases efficiency. </p>
                        </div>
                    </li>
                    <li data-title="What modules Merchant Bay offers in Order Management Dashboard?">
                        <div class="collapsible-header">
                            <h4>What modules Merchant Bay offers in Order Management Dashboard?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Merchant Bay offers solutions for merchandising, production monitoring, BTB monitoring, and store management. </p>
                        </div>
                    </li>
                    <!-- What end -->

                    <!-- How Start -->
                    <li data-title="How can I buy from Merchant Bay?">
                        <div class="collapsible-header">
                            <h4>How can I buy from Merchant Bay?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>You can access the catalog of <a href="{{route('product.type.mapping',['studio', 'design'])}}">designs</a>, library of <a href="{{route('product.type.mapping',['raw_materials', 'textile'])}}">textile</a>, <a href="{{route('product.type.mapping',['raw_materials', 'yarn'])}}">yarn</a> and <a href="{{route('product.type.mapping',['raw_materials', 'trims and accessories'])}}">accessories</a> and/or send us an <a href="{{route('rfq.create')}}">RFQ</a>. We match your query with the best supplier of your interest within 48 hours. </p>
                        </div>
                    </li>
                    <li data-title="How can I sell in Merchant Bay?">
                        <div class="collapsible-header">
                            <h4>How can I sell in Merchant Bay?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p><a href="{{env('SSO_REGISTRATION_URL').'/?flag=global'}}">Sign up</a> to Merchant Bay then open a business profile and list out your <a href="{{route('product.type.mapping',['studio', 'design'])}}">designs</a>, production samples and <a href="{{route('product.type.mapping',['studio', 'ready stock'])}}">ready stock products</a>. </p>
                        </div>
                    </li>
                    <li data-title="How can I open my business profile in Merchant Bay?">
                        <div class="collapsible-header">
                            <h4>How can I open my business profile in Merchant Bay?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>You can open a business profile through a <a href="{{route('business.profile.create')}}">business profile builder</a>. For that you need to have a supplier account in Merchant Bay. Once your supplier account is created you can click the <a href="{{route('business.profile.create')}}">Join MB Pool</a> Button and start building your Business Profile.</p>
                        </div>
                    </li>
                    <li data-title="How can I connect with Merchant Bay?">
                        <div class="collapsible-header">
                            <h4>How can I connect with Merchant Bay?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>You can connect with Merchant Bay through clicking the <a href="javascript:void(0);" itemprop="Talk to us" onclick="Calendly.initPopupWidget({url: 'https://calendly.com/merchantbay/virtual-meeting'});return false;">Talk to us</a> button and setting up an appointment.</p>
                        </div>
                    </li>
                    <li data-title="How can I verify my business profile?">
                        <div class="collapsible-header">
                            <h4>How can I verify my business profile?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>After you create a business profile, a Merchant Bay representative will contact you to discuss the verification process.</p>
                        </div>
                    </li>
                    <li data-title="How to post an RFQ?">
                        <div class="collapsible-header">
                            <h4>How to post an RFQ?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>You can post RFQ by clicking on the <a target="_blank" href="https://www.merchantbay.com/rfq/create">Submit a Request for Quotation</a> button. Provide the necessary details and click submit.</p>
                        </div>
                    </li>
                    <li data-title="How does RFQ work?">
                        <div class="collapsible-header">
                            <h4>How does RFQ work?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p><a href="{{route('rfq.create')}}">RFQ</a> is designed to handle the complexity of the sourcing. Our algorithm matches your query with <a href="{{route('suppliers')}}">suppliers</a> and come back with suggestions instantly. </p>
                        </div>
                    </li>
                    <li data-title="How long does product development take in Merchant Bay?">
                        <div class="collapsible-header">
                            <h4>How long does product development take in Merchant Bay?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Product development is subject to product complexity. We promise industry leading development time. </p>
                        </div>
                    </li>
                    <li data-title="How can I get latest updates from Merchant Bay?">
                        <div class="collapsible-header">
                            <h4>How can I get latest updates from Merchant Bay?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>You can subscribe to our newsletters and follow us on social media networks. Merchant Bay posts its updates in <a target="_blank" href="https://www.facebook.com/merchantbaybd">Facebook</a>, <a target="_blank" href="https://twitter.com/merchantbay_com">Twitter</a>, <a target="_blank" href="https://www.linkedin.com/company/merchantbay/mycompany/">Linkedin</a> and <a target="_blank" href="https://www.instagram.com/merchant.bay/">Instagram</a>.</p>
                        </div>
                    </li>
                    <!-- How end -->

                    <!-- Can start -->
                    <li data-title="Can I buy from abroad?">
                        <div class="collapsible-header">
                            <h4>Can I buy from abroad?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Yes, you can buy from Merchant Bay from anywhere in the world.</p>
                        </div>
                    </li>
                    <li data-title="Can I buy one piece?">
                        <div class="collapsible-header">
                            <h4>Can I buy one piece?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Merchant Bay offers products based on MOQ (Minimum Order Quantity), however if any supplier offers MOQ of 1 piece then it’s possible to buy one piece. </p>
                        </div>
                    </li>
                    <li data-title="Can I open multiple business profiles?">
                        <div class="collapsible-header">
                            <h4>Can I open multiple business profiles?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Yes, you can open business profiles for each of your unique production unites. </p>
                        </div>
                    </li>
                    <li data-title="Can I assign a representative in a profile?">
                        <div class="collapsible-header">
                            <h4>Can I assign a representative in a profile?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Yes, you can assign a representative. In fact, it's recommended to assign a representative to a business profile.</p>
                        </div>
                    </li>
                    <li data-title="Can I sell my designs in Merchant Bay?">
                        <div class="collapsible-header">
                            <h4>Can I sell my designs in Merchant Bay?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>You can contact Merchant Bay to get the process started.</p>
                        </div>
                    </li>
                    <li data-title="Can Merchant Bay manage the compliance and regulatory aspect of a product?">
                        <div class="collapsible-header">
                            <h4>Can Merchant Bay manage the compliance and regulatory aspect of a product?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Merchant Bay <a href="{{route('suppliers')}}">suppliers</a> are compliant and they all have the necessary certifications and regulatory standards applicable in their respective sector. Merchant Bay keeps updated information related to compliance and regulatory information in the profile so that you always get the best suggestion. </p>
                        </div>
                    </li>
                    <!-- Can End -->

                    <!-- Others start -->
                    <li data-title="Does Merchant Bay have a Mobile App?">
                        <div class="collapsible-header">
                            <h4>Does Merchant Bay have a Mobile App?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Yes, the Merchant Bay app is available in both Android and IOS. Links are ….</p>
                            <p>IOS: <a target="_blank" href="https://apps.apple.com/us/app/merchant-bay/id1590720968">https://apps.apple.com/us/app/merchant-bay/id1590720968</a> </p>
                            <p>Android: <a target="_blank" href="https://play.google.com/store/apps/details?id=com.sayemgroup.merchantbay">https://play.google.com/store/apps/details?id=com.sayemgroup.merchantbay</a></p>
                        </div>
                    </li>
                    <li data-title="Which Country is Merchant Bay Based in?">
                        <div class="collapsible-header">
                            <h4>Which Country is Merchant Bay Based in?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Merchant Bay is registered in Bangladesh & Singapore.</p>
                        </div>
                    </li>
                    <li data-title="Does Merchant Bay share my data with anyone?">
                        <div class="collapsible-header">
                            <h4>Does Merchant Bay share my data with anyone?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>No, your data is private and Merchant Bay does not share your data with anyone. </p>
                        </div>
                    </li>
                    <li data-title="Does Merchant Bay offer design support?">
                        <div class="collapsible-header">
                            <h4>Does Merchant Bay offer design support?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Yes, Merchant Bay has a world class <a href="{{route('product.type.mapping',['studio', 'design'])}}">design</a> team for customer design support.</p>
                        </div>
                    </li>
                    <li data-title="Are Merchant Bay in-house designers up-to-date with latest fashion trends?">
                        <div class="collapsible-header">
                            <h4>Are Merchant Bay in-house designers up-to-date with latest fashion trends?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Yes, Merchant Bay's designers constantly stay up-to-date with latest trends in fashion. </p>
                        </div>
                    </li>
                    <li data-title="Do Merchant Bay work with start-up brands and small businesses?">
                        <div class="collapsible-header">
                            <h4>Do Merchant Bay work with start-up brands and small businesses?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Yes, Merchant Bay empowers new brands and SME factories to source and operate efficiently. To know more <a href="javascript:void(0);" class="btn_green btn_talk" itemprop="Talk to us" onclick="Calendly.initPopupWidget({url: 'https://calendly.com/merchantbay/virtual-meeting'});return false;">Book a Call</a>. </p>
                        </div>
                    </li>
                    <li data-title="Do Merchant Bay have factory support?">
                        <div class="collapsible-header">
                            <h4>Do Merchant Bay have factory support?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Yes, Merchant Bay has vast <a href="{{route('suppliers')}}">suppliers</a> in its supplier pool. </p>
                        </div>
                    </li>
                    <li data-title="Do Merchant Bay have sample support?">
                        <div class="collapsible-header">
                            <h4>Do Merchant Bay have sample support?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Merchant Bay provides sample support.</p>
                        </div>
                    </li>
                    <li data-title="Do Merchant Bay have merchandiser support?">
                        <div class="collapsible-header">
                            <h4>Do Merchant Bay have merchandiser support?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Yes, Merchant Bay has experienced merchandisers to provide user support. </p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div id="faqCategoryWhat" class="tabcontent" style="display: none;">
            <div class="faq_collaps_content">
                <ul class="collapsible">
                    <!-- What start -->
                    <li>
                        <div class="collapsible-header">
                            <h4>What is Merchant Bay Limited?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Merchant Bay is an e-supply chain platform and SaaS provider for the readymade garment industry.</p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">
                            <h4>What are the services Merchant Bay offers?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Merchant Bay offers an easy access point to Bangladesh RMG industry. From <a href="{{route('product.type.mapping',['studio', 'design'])}}">design</a>, product development and <a href="{{route('product.type.mapping',['raw_materials', 'textile'])}}">material sourcing</a>, Merchant Bay has it all in one place so that your sourcing experience become easy, transparent and traceable.</p>
                            <p>Merchant Bay does this by making Bangladesh's RMG supply chain visible. Supplier profiles are elaborate and made to increase trust and global reach. Manufacturers can also source raw materials and subscribe to <a href="https://accounts.merchantbay.com/login">Smart Order Management Dashboard</a> to increase their operational efficiency.</p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">
                            <h4>What makes Merchant Bay unique?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Merchant Bay is the only platform providing the easy and simple one click accesses to the Bangladesh RMG industry. You can bring your ideas into reality with Merchant Bay's vertically integrated RMG supply chain. </p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">
                            <h4>What products can I buy from Merchant Bay?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>You can source anything related to RMG manufacturing from Merchant Bay. We have a diverse product catalog ranging from <a href="{{route('product.type.mapping',['studio', 'design'])}}">design</a>, <a href="{{route('product.type.mapping',['raw_materials', 'textile'])}}">textile</a>, <a href="{{route('product.type.mapping',['raw_materials', 'yarn'])}}">yarn</a>, <a href="{{route('product.type.mapping',['raw_materials', 'trims and accessories'])}}">trims and accessories</a>. </p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">
                            <h4>What is the price range for Merchant Bay's products?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Price largely depends on <a href="{{route('product.type.mapping',['studio', 'design'])}}">design</a> and volume. To get the price for your design send us a <a href="{{route('rfq.create')}}">Request for Quotation</a>.</p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">
                            <h4>What if I need to modify a product, like I need to attach my logo in design?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>You can modify a design to your needs. You can also develop your own design with Merchant Bay <a href="{{route('product.type.mapping',['studio', 'design'])}}">Studio</a>.</p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">
                            <h4>What to do if I don't find what I am looking for?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Post an <a href="{{route('rfq.create')}}">RFQ</a> specifying your product. <a href="{{route('suppliers')}}">Suppliers</a> will develop your concept to <a href="{{route('product.type.mapping',['studio', 'design'])}}">design</a>.</p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">
                            <h4>What is an RFQ?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Ans: <a href="{{route('rfq.create')}}">RFQ</a> is the system that enables Merchant Bay users to post the request and get matched <a href="{{route('suppliers')}}">suppliers</a> to source anything related to apparel in minimum time. Our matching system is 2x more efficient compared to traditional process. </p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">
                            <h4>What to do if I don’t receive any reply on my RFQ?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Report a complaint or <a href="javascript:void(0);" itemprop="Talk to us" onclick="Calendly.initPopupWidget({url: 'https://calendly.com/merchantbay/virtual-meeting'});return false;">Contact</a> Merchant Bay, we will get in touch with you as soon as possible.</p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">
                            <h4>What is a Smart Order Management Dashboard?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p><a href="https://omd.merchantbay.com/">Smart Order Management Dashboard</a> provides easy actionable data to help ease the burden of maintaining multiple orders. Smart OMD reduces order complexities and increases efficiency. </p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">
                            <h4>What modules Merchant Bay offers in Order Management Dashboard?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Merchant Bay offers solutions for merchandising, production monitoring, BTB monitoring, and store management.</p>
                        </div>
                    </li>
                    <!-- What end -->
                </ul>
            </div>
        </div>

        <div id="faqCategoryHow" class="tabcontent" style="display: none;">
            <div class="faq_collaps_content">
                <ul class="collapsible">
                    <!-- How Start -->
                    <li>
                        <div class="collapsible-header">
                            <h4>How can I buy from Merchant Bay?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>You can access the catalog of <a href="{{route('product.type.mapping',['studio', 'design'])}}">designs</a>, library of <a href="{{route('product.type.mapping',['raw_materials', 'textile'])}}">textile</a>, <a href="{{route('product.type.mapping',['raw_materials', 'yarn'])}}">yarn</a> and <a href="{{route('product.type.mapping',['raw_materials', 'trims and accessories'])}}">accessories</a> and/or send us an <a href="{{route('rfq.create')}}">RFQ</a>. We match your query with the best supplier of your interest within 48 hours. </p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">
                            <h4>How can I sell in Merchant Bay?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p><a href="{{env('SSO_REGISTRATION_URL').'/?flag=global'}}">Sign up</a> to Merchant Bay then open a business profile and list out your <a href="{{route('product.type.mapping',['studio', 'design'])}}">designs</a>, production samples and <a href="{{route('product.type.mapping',['studio', 'ready_stock'])}}">ready stock products</a>.</p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">
                            <h4>How can I open my business profile in Merchant Bay?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>You can open a business profile through a <a href="{{route('business.profile.create')}}">business profile builder</a>. For that you need to have a supplier account in Merchant Bay. Once your supplier account is created you can click the <a href="{{route('business.profile.create')}}">Join MB Pool</a> Button and start building your Business Profile.</p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">
                            <h4>How can I connect with Merchant Bay?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>You can connect with Merchant Bay through clicking the <a href="javascript:void(0);" itemprop="Talk to us" onclick="Calendly.initPopupWidget({url: 'https://calendly.com/merchantbay/virtual-meeting'});return false;">Talk to us</a> button and setting up an appointment.</p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">
                            <h4>How can I verify my business profile?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>After you create a business profile, a Merchant Bay representative will contact you to discuss the verification process.</p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">
                            <h4>How to post an RFQ?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>You can post RFQ by clicking on the <a target="_blank" href="https://www.merchantbay.com/rfq/create">Submit a Request for Quotation</a> button. Provide the necessary details and click submit.</p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">
                            <h4>How does RFQ work?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p><a href="{{route('rfq.create')}}">RFQ</a> is designed to handle the complexity of the sourcing. Our algorithm matches your query with <a href="{{route('suppliers')}}">suppliers</a> and come back with suggestions instantly. </p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">
                            <h4>How long does product development take in Merchant Bay?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Product development is subject to product complexity. We promise industry leading development time. </p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">
                            <h4>How can I get latest updates from Merchant Bay?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>You can subscribe to our newsletters and follow us on social media networks. Merchant Bay posts its updates in <a target="_blank" href="https://www.facebook.com/merchantbaybd">Facebook</a>, <a target="_blank" href="https://twitter.com/merchantbay_com">Twitter</a>, <a target="_blank" href="https://www.linkedin.com/company/merchantbay/mycompany/">Linkedin</a> and <a target="_blank" href="https://www.instagram.com/merchant.bay/">Instagram</a>.</p>
                        </div>
                    </li>
                    <!-- How end -->
                </ul>
            </div>
        </div>

        <div id="faqCategoryCan" class="tabcontent" style="display: none;">
            <div class="faq_collaps_content">
                <ul class="collapsible">
                    <!-- Can start -->
                    <li>
                        <div class="collapsible-header">
                            <h4>Can I buy from abroad?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Yes, you can buy from Merchant Bay from anywhere in the world.</p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">
                            <h4>Can I buy one piece?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Merchant Bay offers products based on MOQ (Minimum Order Quantity), however if any supplier offers MOQ of 1 piece then it's possible to buy one piece.</p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">
                            <h4>Can I open multiple business profiles?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Yes, you can open business profiles for each of your unique production unites. </p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">
                            <h4>Can I assign a representative in a profile?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Yes, you can assign a representative. In fact, it's recommended to assign a representative to a business profile.</p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">
                            <h4>Can I sell my designs in Merchant Bay?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>You can contact Merchant Bay to get the process started.</p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">
                            <h4>Can Merchant Bay manage the compliance and regulatory aspect of a product? </h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Merchant Bay <a href="{{route('suppliers')}}">suppliers</a> are compliant and they all have the necessary certifications and regulatory standards applicable in their respective sector. Merchant Bay keeps updated information related to compliance and regulatory information in the profile so that you always get the best suggestion. </p>
                        </div>
                    </li>
                    <!-- Can End -->
                </ul>
            </div>
        </div>
        <div id="faqCategoryOthers" class="tabcontent" style="display: none;">
            <div class="faq_collaps_content">
                <ul class="collapsible">
                    <!-- Others start -->
                    <li>
                        <div class="collapsible-header">
                            <h4>Does Merchant Bay have a Mobile App?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Yes, the Merchant Bay app is available in both Android and IOS. Links are ….</p>
                            <p>IOS: <a target="_blank" href="https://apps.apple.com/us/app/merchant-bay/id1590720968">https://apps.apple.com/us/app/merchant-bay/id1590720968</a> </p>
                            <p>Android: <a target="_blank" href="https://play.google.com/store/apps/details?id=com.sayemgroup.merchantbay">https://play.google.com/store/apps/details?id=com.sayemgroup.merchantbay</a></p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">
                            <h4>Which Country is Merchant Bay Based in?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Merchant Bay is registered in Bangladesh & Singapore.</p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">
                            <h4>Does Merchant Bay share my data with anyone?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>No, your data is private and Merchant Bay does not share your data with anyone. </p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">
                            <h4>Does Merchant Bay offer design support? </h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Yes, Merchant Bay has a world class <a href="{{route('product.type.mapping',['studio', 'design'])}}">design</a> team for customer design support.</p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">
                            <h4>Are Merchant Bay in-house designers up-to-date with latest fashion trends?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Yes, Merchant Bay's designers constantly stay up-to-date with latest trends in fashion. </p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">
                            <h4>Do Merchant Bay work with start-up brands and small businesses?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Yes, Merchant Bay empowers new brands and SME factories to source and operate efficiently. To know more <a href="javascript:void(0);" class="btn_green btn_talk" itemprop="Talk to us" onclick="Calendly.initPopupWidget({url: 'https://calendly.com/merchantbay/virtual-meeting'});return false;">Book a Call</a>. </p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">
                            <h4>Do Merchant Bay have factory support?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Yes, Merchant Bay has vast <a href="{{route('suppliers')}}">suppliers</a> in its supplier pool. </p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">
                            <h4>Do Merchant Bay have sample support?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Merchant Bay provides sample support.</p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">
                            <h4>Do Merchant Bay have merchandiser support?</h4>
                        </div>
                        <div class="collapsible-body">
                            <p>Yes, Merchant Bay has experienced merchandisers to provide user support. </p>
                        </div>
                    </li>
                    <!-- Others end -->
                </ul>
            </div>
        </div>
    </div>

    <div class="faq_talkToUs_boxWrap center-align faq_talkToUs_boxWrap_mobile" style="display: none;">
        <h3>Still have questions?</h3>
        <a href="javascript:void(0);" class="btn_green btn_talk" itemprop="Talk to us" onclick="Calendly.initPopupWidget({url: 'https://calendly.com/merchantbay/virtual-meeting'});return false;">Talk to us <i class="material-icons"> east </i></a>
    </div>
</div>

@endsection

@push('js')
<script>
function faqCategory(evt, faqCategory) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(faqCategory).style.display = "block";
    evt.currentTarget.className += " active";
}
$(document).ready(function(){

    var $input = $(".typeahead");
    $input.typeahead({
        source: [
            "What is Merchant Bay Limited?",
            "What are the services Merchant Bay offers?",
            "What makes Merchant Bay unique?",
            "What products can I buy from Merchant Bay?",
            "What is the price range for Merchant Bay's products?",
            "How can I get latest updates from Merchant Bay?",
            "What if I need to modify a product, like I need to attach my logo in design?",
            "What to do if I don't find what I am looking for?",
            "What is an RFQ?",
            "What to do if I don't receive any reply on my RFQ?",
            "What is a Smart Order Management Dashboard?",
            "What modules Merchant Bay offers in Order Management Dashboard?",
            "How can I buy from Merchant Bay?",
            "How can I sell in Merchant Bay?",
            "How can I open my business profile in Merchant Bay?",
            "How can I connect with Merchant Bay?",
            "How can I verify my business profile?",
            "How to post an RFQ?",
            "How does RFQ work?",
            "How long does product development take in Merchant Bay?",
            "Can I buy from abroad?",
            "Can I buy one piece?",
            "Can I open multiple business profiles?",
            "Can I assign a representative in a profile?",
            "Can I sell my designs in Merchant Bay?",
            "Can Merchant Bay manage the compliance and regulatory aspect of a product?",
            "Does Merchant Bay have a Mobile App?",
            "Which Country is Merchant Bay Based in?",
            "Does Merchant Bay share my data with anyone?",
            "Does Merchant Bay offer design support?",
            "Are Merchant Bay in-house designers up-to-date with latest fashion trends?",
            "Do Merchant Bay work with start-up brands and small businesses?",
            "Do Merchant Bay have factory support?",
            "Do Merchant Bay have sample support?",
            "Do Merchant Bay have merchandiser support?"
        ],
        autoSelect: true
    });
    $input.change(function() {
        var current = $input.typeahead("getActive");
        if (current) {
            // Some item from your model is active!
            if (current.name == $input.val()) {
            // This means the exact match is found. Use toLowerCase() if you want case insensitive match.
            } else {
            // This means it is only a partial match, you can either add a new item
            // or take the active if you don't want new items
            }
        } else {
            // Nothing is active so it is a new value (or maybe empty value)
        }
    });

    $(".collapsible").collapsible({
        accordion:true
    });

    $(".faq_search_input").change(function(){
        var foundCount = 0;
        var inputText = String($(this).val());
        $(".data-title-filter li").each(function() {
            var listFind = String($(this).data("title"));
            if (inputText == listFind)
            {
                $(".rfq_tab_item_box .tablinks").removeClass("active");
                faqCategory(event, 'faqCategoryAll');
                $(".triggerEvent").addClass("active");
                $("#faqCategoryAll li").css("display", "none");
                $(this).css("display", "block");
                $(".reset_faq_filter").show();
                //console.log("Found");
                return;
            }
            else
            {
                foundCount++;
                //$(this).css("display", "none");
                //console.log("Not Found");
                //return;
            }
        });

        //console.log(foundCount);
        if(foundCount == 35)
        {
            $(".rfq_tab_item_box .tablinks").removeClass("active");
            faqCategory(event, 'faqCategoryAll');
            $(".triggerEvent").addClass("active");
            $("#faqCategoryAll li").css("display", "none");
            $(".noFaqItemFound").show();
            $(".reset_faq_filter").show();
        }
        else
        {
            $(".rfq_tab_item_box .tablinks").removeClass("active");
            faqCategory(event, 'faqCategoryAll');
            $(".triggerEvent").addClass("active");
            $(".noFaqItemFound").hide();
            $(".reset_faq_filter").show();
        }
    });

    $(".reset_faq_filter").click(function(){
        $(".faq_search_input").val("");
        window.location.reload();
    });
});
</script>
@endpush
