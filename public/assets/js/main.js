const mobileMenuBtn = document.getElementById('mobileMenuBtn');
const mobileMenu = document.getElementById('mobileMenu');
const year = document.getElementById('year');
const themeToggle = document.getElementById('themeToggle');
const themeToggleMobile = document.getElementById('themeToggleMobile');
const body = document.body;
const logoImages = document.querySelectorAll('[data-logo-dark][data-logo-light]');
const pageTitle = document.getElementById('pageTitle');
const pageDescription = document.getElementById('pageDescription');
const ogTitle = document.getElementById('ogTitle');
const ogDescription = document.getElementById('ogDescription');
const twitterTitle = document.getElementById('twitterTitle');
const twitterDescription = document.getElementById('twitterDescription');
const langButtons = document.querySelectorAll('.lang-btn');
const servicesChartCanvas = document.getElementById('servicesChart');
const chatbotToggle = document.getElementById('chatbotToggle');
const chatbotClose = document.getElementById('chatbotClose');
const chatbotPanel = document.getElementById('chatbotPanel');
const chatbotMessages = document.getElementById('chatbotMessages');
const chatbotForm = document.getElementById('chatbotForm');
const chatbotInput = document.getElementById('chatbotInput');
const chatbotQuickButtons = document.querySelectorAll('[data-chatbot-prompt]');
let currentLanguage = 'id';
let servicesChart = null;

const translations = {
    id: {
        title: 'PT Fluxa Tritama Indonesia | Solusi Digital, Pengembangan Aplikasi & Infrastruktur Bisnis',
        description: 'PT Fluxa Tritama Indonesia menyediakan solusi digital, pengembangan aplikasi web dan mobile, infrastruktur jaringan, IT procurement, dan transformasi digital untuk bisnis di Indonesia.',
        nav: { about: 'Tentang', services: 'Layanan', industries: 'Industri', projects: 'Proyek', process: 'Proses', contact: 'Kontak' },
        cta: { email: 'Email Kami', consult: 'Konsultasi' },
        hero: {
            badge: 'Every Flow Builds The Future',
            title1: 'Solusi IT profesional untuk bisnis yang ingin',
            title2: 'tumbuh lebih cepat dan lebih terstruktur.',
            slogan: 'Every Flow Builds The Future',
            desc: 'PT Fluxa Tritama Indonesia membantu perusahaan membangun sistem digital, aplikasi bisnis, dan infrastruktur IT yang aman, efisien, serta mudah dikembangkan.',
            ctaPrimary: 'Diskusikan Kebutuhan',
            ctaSecondary: 'Lihat Layanan',
            chip1: 'Aplikasi Web & Mobile',
            chip2: 'Infrastruktur & Jaringan',
            chip4: 'Otomasi Bisnis'
        },
        snapshot: {
            badge: 'Company Snapshot',
            titleLine1: 'Why PT Fluxa',
            titleLine2: 'Tritama Indonesia',
            metric1: 'Inisiatif digital dan implementasi IT',
            metric2: 'Klien dari berbagai sektor bisnis',
            metric3: 'Tahun pengalaman delivery project',
            metric4: 'Dukungan untuk operasional penting',
            desc: 'Sistem yang stabil, workflow yang lebih cepat, dan fondasi teknologi yang siap dipakai untuk scale-up.'
        },
        values: {
            badge: 'Nilai Utama',
            title: 'Partner teknologi yang tidak sekadar membangun, tapi membantu bisnis bergerak lebih cepat.',
            card1Title: 'Keamanan & Keandalan',
            card1Desc: 'Arsitektur dan implementasi dibangun dengan standar keamanan dan kestabilan operasional.',
            card2Title: 'Eksekusi yang Jelas',
            card2Desc: 'Roadmap, milestone, dan komunikasi project disusun jelas agar keputusan bisnis lebih cepat.'
        },
        about: {
            badge: 'Tentang Kami',
            title: 'PT Fluxa Tritama Indonesia hadir untuk memperkuat transformasi digital bisnis di Indonesia.',
            desc1: 'Kami adalah perusahaan IT yang membantu organisasi merancang, membangun, dan mengelola solusi teknologi yang benar-benar dipakai untuk operasional dan pertumbuhan bisnis.',
            desc2: 'Fokus kami ada pada kualitas delivery, kejelasan proses, dan solusi yang relevan dengan kebutuhan lapangan, mulai dari aplikasi internal hingga infrastruktur enterprise.',
            card1Title: 'Solusi Berbasis Bisnis',
            card1Desc: 'Setiap solusi dibangun untuk menjawab kebutuhan proses, efisiensi, dan target bisnis yang konkret.',
            card2Title: 'Delivery Terstruktur',
            card2Desc: 'Workflow project dibuat terukur agar progres lebih transparan dan lebih mudah dikontrol.',
            card3Title: 'Fondasi yang Scalable',
            card3Desc: 'Infrastruktur dan sistem dirancang agar siap berkembang mengikuti kebutuhan bisnis berikutnya.',
            card4Title: 'Dukungan Jangka Panjang',
            card4Desc: 'Kami tidak berhenti di go-live. Dukungan lanjutan membantu sistem tetap sehat dan relevan.'
        },
        heroVisual: {
            badge: 'Live Delivery Focus',
            desc: 'Solusi digital disusun dengan pendekatan visual, data, dan implementasi yang siap dipresentasikan ke calon klien maupun stakeholder internal.',
            metric1: 'Project visibility',
            metric2: 'Client rating'
        },
        vision: {
            badge: 'Visi & Misi',
            title: 'Arah strategis PT Fluxa Tritama Indonesia dalam membangun solusi digital yang relevan dan bernilai.',
            visionLabel: 'Visi',
            visionText: 'Menjadi perusahaan teknologi terpercaya yang menghadirkan solusi digital inovatif, adaptif, dan bernilai untuk mendukung pertumbuhan bisnis di era digital.',
            missionLabel: 'Misi',
            mission1Title: 'Mengembangkan solusi digital yang tepat guna',
            mission1Desc: 'Membangun website, aplikasi, sistem informasi, dan layanan teknologi yang sesuai dengan kebutuhan bisnis klien.',
            mission2Title: 'Memberikan layanan yang profesional dan berkelanjutan',
            mission2Desc: 'Menjaga kualitas pekerjaan, komunikasi, serta dukungan teknis agar setiap solusi dapat digunakan secara optimal.',
            mission3Title: 'Mendorong transformasi digital bisnis',
            mission3Desc: 'Membantu pelaku usaha, organisasi, dan instansi dalam meningkatkan efisiensi melalui teknologi.',
            mission4Title: 'Mengutamakan inovasi dan keandalan',
            mission4Desc: 'Menghadirkan sistem yang modern, aman, mudah digunakan, dan dapat dikembangkan sesuai kebutuhan masa depan.',
            mission5Title: 'Membangun nilai melalui setiap solusi',
            mission5Desc: 'Menjadikan setiap ide, proses, dan teknologi sebagai karya yang memberi manfaat nyata bagi pengguna dan klien.'
        },
        services: {
            badge: 'Layanan',
            title: 'Solusi IT yang dirancang untuk kebutuhan operasional dan pertumbuhan bisnis.',
            desc: 'Kami menggabungkan pengembangan software, infrastruktur, dan konsultasi implementasi untuk membantu bisnis berjalan lebih efektif.',
            card1Title: 'Pengembangan Aplikasi',
            card1Desc: 'Pengembangan aplikasi web, mobile, dan sistem internal untuk digitalisasi proses bisnis dan layanan pelanggan.',
            card2Title: 'Infrastruktur & Jaringan',
            card2Desc: 'Perencanaan dan implementasi infrastruktur IT, jaringan, serta lingkungan operasional yang aman dan stabil.',
            card3Title: 'IT Procurement',
            card3Desc: 'Pengadaan perangkat keras, perangkat lunak, dan kebutuhan teknis lain dengan pendekatan yang efisien dan tepat guna.'
        },
        media: {
            badge: 'Visual Showcase',
            title: 'Visual desktop yang lebih rapi dengan komposisi editorial, foto profesional, dan hierarchy yang lebih meyakinkan.',
            desc: 'Section ini membantu calon klien melihat suasana kerja, pendekatan delivery, dan kualitas visual brand dalam satu alur yang lebih meyakinkan.',
            card1Badge: 'Foto',
            card1Title: 'Corporate Tech Photo',
            card1Desc: 'Cocok untuk memperkuat persepsi profesional, modern, dan siap eksekusi.',
            card2Badge: 'Layout',
            card2Title: 'Desktop Presentation',
            card2Desc: 'Disusun supaya area kanan terasa premium tanpa terlihat seperti placeholder demo.'
        },
        insight: {
            badge: 'Performance Insight',
            title: 'Tambahkan chart agar company profile terasa lebih berbasis data dan lebih kredibel saat dipresentasikan.',
            desc: 'Grafik ini bisa dipakai untuk menunjukkan pertumbuhan delivery, efektivitas implementasi, dan fokus prioritas layanan dalam bentuk yang cepat dipahami.',
            stat1: 'Efisiensi workflow digital',
            stat2: 'Faster reporting cycle',
            stat3: 'Stability target',
            chartBadge: 'Delivery Growth Overview',
            chartTitle: 'Service Mix & Impact',
            chartNote: 'Demo chart untuk company profile'
        },
        industries: {
            badge: 'Sektor yang Dilayani',
            title: 'Relevan untuk berbagai jenis organisasi dan kebutuhan implementasi IT.',
            desc: 'Pendekatan kami fleksibel untuk perusahaan yang sedang membenahi proses internal, membangun produk digital, atau memperkuat fondasi infrastrukturnya.',
            card1Title: 'Corporate & SME',
            card1Desc: 'Digitalisasi workflow, dashboard operasional, dan sistem pendukung keputusan.',
            card2Title: 'Retail & Distribution',
            card2Desc: 'Integrasi penjualan, inventory, reporting, dan monitoring aktivitas cabang.',
            card3Title: 'Education & Public Service',
            card3Desc: 'Sistem informasi, portal layanan, dan tata kelola data yang lebih tertata.',
            card4Title: 'Industrial Operations',
            card4Desc: 'Jaringan, monitoring, dan solusi penunjang operasional di lapangan.'
        },
        portfolio: {
            badge: 'Kapabilitas',
            title: 'Contoh area solusi yang bisa kami kerjakan untuk bisnis Anda.',
            card1Title: 'Executive Dashboard',
            card1Desc: 'Dashboard ringkas untuk memantau KPI, operasional, penjualan, dan data penting lintas unit bisnis.',
            card2Title: 'Customer-Facing Apps',
            card2Desc: 'Aplikasi dan portal yang membantu bisnis meningkatkan layanan pelanggan dan pengalaman digital.',
            card3Title: 'Infrastructure Modernization',
            card3Desc: 'Pembaruan jaringan, server, dan lingkungan IT agar lebih aman, tertata, dan siap menunjang pertumbuhan.'
        },
        process: {
            badge: 'Proses Kerja',
            title: 'Cara kami memastikan project tetap jelas, terarah, dan deliverable.',
            desc: 'Struktur kerja yang rapi membantu mengurangi risiko miskomunikasi, mempercepat validasi, dan menjaga kualitas implementasi.',
            step1Title: 'Discovery & Requirement Mapping',
            step1Desc: 'Kami memetakan kebutuhan bisnis, proses berjalan, dan target implementasi sebelum masuk ke tahap eksekusi.',
            step2Title: 'Solution Design',
            step2Desc: 'Arsitektur solusi, alur kerja, dan prioritas implementasi disusun agar keputusan teknis tetap selaras dengan kebutuhan bisnis.',
            step3Title: 'Build & Implementation',
            step3Desc: 'Tim menjalankan pengembangan, setup, dan konfigurasi dengan pendekatan yang terukur dan terdokumentasi.',
            step4Title: 'Testing, Handover & Support',
            step4Desc: 'Solusi divalidasi, diserahterimakan dengan jelas, lalu didukung agar tetap stabil saat digunakan di lapangan.'
        },
        contact: {
            badge: 'Kontak',
            title: 'Bangun company profile dan sistem digital yang terlihat lebih profesional di mata calon klien.',
            desc: 'Jika Anda butuh website company profile, aplikasi internal, atau infrastruktur IT yang lebih rapi, kami siap bantu dari tahap perencanaan sampai implementasi.',
            cta1: 'Chat via WhatsApp',
            cta2: 'Kirim Email',
            card1: 'Email',
            card2: 'Telepon / WhatsApp',
            card3: 'Lokasi',
            location: 'Kalimantan, Indonesia'
        },
        chatbot: {
            badge: 'Chatbot Demo',
            title: 'Fluxa Assistant',
            welcome: 'Halo, saya siap bantu menjelaskan layanan PT Fluxa Tritama Indonesia. Anda bisa tanya soal website, aplikasi, infrastruktur, atau konsultasi awal.',
            quick1: 'Layanan apa saja?',
            quick2: 'Bisa buat website?',
            quick3: 'Cara konsultasi?'
        },
        clients: { title: 'Clients' },
        footer: {
            taglinePrefix: 'PT Fluxa Tritama Indonesia menghadirkan layanan teknologi dan solusi digital untuk kebutuhan bisnis modern',
            taglineSuffix: '.',
            copySuffix: 'All rights reserved.'
        }
    },
    en: {
        title: 'PT Fluxa Tritama Indonesia | Digital Solutions, App Development & Business Infrastructure',
        description: 'PT Fluxa Tritama Indonesia provides digital solutions, web and mobile app development, network infrastructure, IT procurement, and digital transformation for businesses in Indonesia.',
        nav: { about: 'About', services: 'Services', industries: 'Industries', projects: 'Projects', process: 'Process', contact: 'Contact' },
        cta: { email: 'Email Us', consult: 'Consult' },
        hero: {
            badge: 'Every Flow Builds The Future',
            title1: 'Professional IT solutions for businesses that want to',
            title2: 'grow faster and operate with more structure.',
            slogan: 'Every Flow Builds The Future',
            desc: 'PT Fluxa Tritama Indonesia helps companies build digital systems, business applications, and IT infrastructure that are secure, efficient, and easy to scale.',
            ctaPrimary: 'Discuss Your Needs',
            ctaSecondary: 'View Services',
            chip1: 'Web & Mobile Apps',
            chip2: 'Infrastructure & Network',
            chip4: 'Business Automation'
        },
        snapshot: {
            badge: 'Company Snapshot',
            titleLine1: 'Why PT Fluxa',
            titleLine2: 'Tritama Indonesia',
            metric1: 'Digital initiatives and IT implementations',
            metric2: 'Clients across multiple business sectors',
            metric3: 'Years of project delivery experience',
            metric4: 'Support for critical operations',
            desc: 'Stable systems, faster workflows, and technology foundations that are ready to scale.'
        },
        values: {
            badge: 'Core Value',
            title: 'A technology partner that does more than build systems. We help businesses move faster.',
            card1Title: 'Security & Reliability',
            card1Desc: 'Architecture and implementation are built with operational stability and security standards in mind.',
            card2Title: 'Execution with Clarity',
            card2Desc: 'Roadmaps, milestones, and project communication are structured clearly to speed up business decisions.'
        },
        about: {
            badge: 'About Us',
            title: 'PT Fluxa Tritama Indonesia is here to strengthen digital transformation for businesses in Indonesia.',
            desc1: 'We are an IT company that helps organizations design, build, and manage technology solutions that genuinely support operations and business growth.',
            desc2: 'Our focus is on delivery quality, process clarity, and practical solutions, from internal applications to enterprise infrastructure.',
            card1Title: 'Business-Driven Build',
            card1Desc: 'Every solution is built to address concrete business processes, efficiency targets, and operational goals.',
            card2Title: 'Structured Delivery',
            card2Desc: 'Project workflows are measurable so progress is transparent and easier to control.',
            card3Title: 'Scalable Foundation',
            card3Desc: 'Infrastructure and systems are designed to grow with future business needs.',
            card4Title: 'Long-Term Support',
            card4Desc: 'We do not stop at go-live. Ongoing support keeps systems healthy and relevant.'
        },
        heroVisual: {
            badge: 'Live Delivery Focus',
            desc: 'Digital solutions are shaped with visual clarity, data readiness, and implementation structure for client and stakeholder presentations.',
            metric1: 'Project visibility',
            metric2: 'Client rating'
        },
        vision: {
            badge: 'Vision & Mission',
            title: 'The strategic direction of PT Fluxa Tritama Indonesia in delivering relevant and valuable digital solutions.',
            visionLabel: 'Vision',
            visionText: 'To become a trusted technology company that delivers innovative, adaptive, and valuable digital solutions to support business growth in the digital era.',
            missionLabel: 'Mission',
            mission1Title: 'Develop practical digital solutions',
            mission1Desc: 'Build websites, applications, information systems, and technology services aligned with client business needs.',
            mission2Title: 'Deliver professional and sustainable service',
            mission2Desc: 'Maintain work quality, communication, and technical support so every solution can be used optimally.',
            mission3Title: 'Drive business digital transformation',
            mission3Desc: 'Help businesses, organizations, and institutions improve efficiency through technology.',
            mission4Title: 'Prioritize innovation and reliability',
            mission4Desc: 'Deliver modern, secure, user-friendly systems that can grow with future needs.',
            mission5Title: 'Create value through every solution',
            mission5Desc: 'Turn every idea, process, and technology into work that delivers real benefits for users and clients.'
        },
        services: {
            badge: 'Services',
            title: 'IT solutions designed for operational needs and business growth.',
            desc: 'We combine software development, infrastructure, and implementation consulting to help businesses operate more effectively.',
            card1Title: 'Application Development',
            card1Desc: 'Development of web, mobile, and internal systems to digitize business processes and customer services.',
            card2Title: 'Infrastructure & Network',
            card2Desc: 'Planning and implementing IT infrastructure, networks, and operational environments that are secure and reliable.',
            card3Title: 'IT Procurement',
            card3Desc: 'Procurement of hardware, software, and technical needs with an efficient and practical approach.'
        },
        media: {
            badge: 'Visual Showcase',
            title: 'A cleaner desktop visual system with editorial composition, professional photography, and more convincing hierarchy.',
            desc: 'This section helps prospective clients understand the working atmosphere, delivery approach, and brand quality in a more convincing flow.',
            card1Badge: 'Photo',
            card1Title: 'Corporate Tech Photo',
            card1Desc: 'Ideal for reinforcing a professional, modern, and execution-ready impression.',
            card2Badge: 'Layout',
            card2Title: 'Desktop Presentation',
            card2Desc: 'Structured so the right-side area feels premium instead of reading like a temporary demo block.'
        },
        insight: {
            badge: 'Performance Insight',
            title: 'Use charts to make the company profile feel more data-driven and more credible during presentations.',
            desc: 'This chart can represent delivery growth, implementation effectiveness, and service priorities in a format that is easy to understand quickly.',
            stat1: 'Digital workflow efficiency',
            stat2: 'Faster reporting cycle',
            stat3: 'Stability target',
            chartBadge: 'Delivery Growth Overview',
            chartTitle: 'Service Mix & Impact',
            chartNote: 'Demo chart for company profile'
        },
        industries: {
            badge: 'Industries Served',
            title: 'Relevant for various types of organizations and IT implementation needs.',
            desc: 'Our approach is flexible for companies improving internal processes, building digital products, or strengthening their infrastructure foundation.',
            card1Title: 'Corporate & SME',
            card1Desc: 'Workflow digitization, operational dashboards, and decision-support systems.',
            card2Title: 'Retail & Distribution',
            card2Desc: 'Sales, inventory, reporting, and branch activity monitoring integration.',
            card3Title: 'Education & Public Service',
            card3Desc: 'Information systems, service portals, and better-structured data governance.',
            card4Title: 'Industrial Operations',
            card4Desc: 'Network, monitoring, and field-operation support solutions.'
        },
        portfolio: {
            badge: 'Capabilities',
            title: 'Examples of solution areas we can deliver for your business.',
            card1Title: 'Executive Dashboard',
            card1Desc: 'Compact dashboards to monitor KPIs, operations, sales, and key cross-functional data.',
            card2Title: 'Customer-Facing Apps',
            card2Desc: 'Applications and portals that help businesses improve customer service and digital experience.',
            card3Title: 'Infrastructure Modernization',
            card3Desc: 'Upgrading networks, servers, and IT environments to be more secure, organized, and growth-ready.'
        },
        process: {
            badge: 'Process',
            title: 'How we keep every project clear, directed, and deliverable.',
            desc: 'A structured workflow reduces miscommunication, speeds up validation, and maintains implementation quality.',
            step1Title: 'Discovery & Requirement Mapping',
            step1Desc: 'We map business needs, current processes, and implementation targets before moving into execution.',
            step2Title: 'Solution Design',
            step2Desc: 'Solution architecture, workflows, and implementation priorities are aligned with business needs.',
            step3Title: 'Build & Implementation',
            step3Desc: 'Our team executes development, setup, and configuration in a measurable and documented manner.',
            step4Title: 'Testing, Handover & Support',
            step4Desc: 'Solutions are validated, handed over clearly, and supported to remain stable in real operations.'
        },
        contact: {
            badge: 'Contact',
            title: 'Build a company profile and digital system that looks more professional to prospective clients.',
            desc: 'If you need a company profile website, internal application, or cleaner IT infrastructure, we are ready to help from planning to implementation.',
            cta1: 'Chat via WhatsApp',
            cta2: 'Send Email',
            card1: 'Email',
            card2: 'Phone / WhatsApp',
            card3: 'Location',
            location: 'Kalimantan, Indonesia'
        },
        chatbot: {
            badge: 'Chatbot Demo',
            title: 'Fluxa Assistant',
            welcome: 'Hello, I can help explain PT Fluxa Tritama Indonesia services. You can ask about websites, applications, infrastructure, or initial consultation.',
            quick1: 'What services?',
            quick2: 'Can you build websites?',
            quick3: 'How to consult?'
        },
        clients: { title: 'Clients' },
        footer: {
            taglinePrefix: 'PT Fluxa Tritama Indonesia delivers technology services and digital solutions for modern business needs',
            taglineSuffix: '.',
            copySuffix: 'All rights reserved.'
        }
    },
    zh: {
        title: 'PT Fluxa Tritama Indonesia | æ•°å­—è§£å†³æ–¹æ¡ˆã€åº”ç”¨å¼€å‘ä¸Žä¼ä¸šåŸºç¡€è®¾æ–½',
        description: 'PT Fluxa Tritama Indonesia ä¸ºå°åº¦å°¼è¥¿äºšä¼ä¸šæä¾›æ•°å­—è§£å†³æ–¹æ¡ˆã€Web ä¸Žç§»åŠ¨åº”ç”¨å¼€å‘ã€ç½‘ç»œåŸºç¡€è®¾æ–½ã€IT é‡‡è´­ä¸Žæ•°å­—åŒ–è½¬åž‹æœåŠ¡ã€‚',
        nav: { about: 'å…³äºŽæˆ‘ä»¬', services: 'æœåŠ¡', industries: 'è¡Œä¸š', projects: 'é¡¹ç›®', process: 'æµç¨‹', contact: 'è”ç³»' },
        cta: { email: 'å‘é€é‚®ä»¶', consult: 'å’¨è¯¢' },
        hero: {
            badge: 'Every Flow Builds The Future',
            title1: 'ä¸ºå¸Œæœ›å®žçŽ°',
            title2: 'æ›´å¿«å¢žé•¿ä¸Žæ›´é«˜æ•ˆçŽ‡çš„ä¼ä¸šæä¾›ä¸“ä¸š IT è§£å†³æ–¹æ¡ˆã€‚',
            desc: 'PT Fluxa Tritama Indonesia å¸®åŠ©ä¼ä¸šæž„å»ºå®‰å…¨ã€é«˜æ•ˆä¸”æ˜“äºŽæ‰©å±•çš„æ•°å­—ç³»ç»Ÿã€ä¸šåŠ¡åº”ç”¨å’Œ IT åŸºç¡€è®¾æ–½ã€‚',
            ctaPrimary: 'æ²Ÿé€šéœ€æ±‚',
            ctaSecondary: 'æŸ¥çœ‹æœåŠ¡',
            chip1: 'Web ä¸Žç§»åŠ¨åº”ç”¨',
            chip2: 'åŸºç¡€è®¾æ–½ä¸Žç½‘ç»œ',
            chip4: 'ä¸šåŠ¡è‡ªåŠ¨åŒ–'
        },
        snapshot: {
            badge: 'Company Snapshot',
            titleLine1: 'Why PT Fluxa',
            titleLine2: 'Tritama Indonesia',
            metric1: 'æ•°å­—åŒ–é¡¹ç›®ä¸Ž IT å®žæ–½',
            metric2: 'æ¥è‡ªå¤šä¸ªè¡Œä¸šçš„å®¢æˆ·',
            metric3: 'é¡¹ç›®äº¤ä»˜ç»éªŒå¹´é™',
            metric4: 'å…³é”®ä¸šåŠ¡æ”¯æŒ',
            desc: 'æˆ‘ä»¬ä¸“æ³¨äºŽä¸šåŠ¡æˆæžœï¼šç¨³å®šçš„ç³»ç»Ÿã€æ›´å¿«çš„æµç¨‹ï¼Œä»¥åŠå¯æ”¯æŒä¼ä¸šæ‰©å¼ çš„æŠ€æœ¯åŸºç¡€ã€‚'
        },
        values: {
            badge: 'æ ¸å¿ƒä»·å€¼',
            title: 'æˆ‘ä»¬ä¸ä»…æž„å»ºç³»ç»Ÿï¼Œæ›´å¸®åŠ©ä¼ä¸šæ›´å¿«æŽ¨è¿›ä¸šåŠ¡ã€‚',
            card1Title: 'å®‰å…¨ä¸Žå¯é ',
            card1Desc: 'æž¶æž„ä¸Žå®žæ–½å‡ä»¥å®‰å…¨æ ‡å‡†å’Œè¿è¥ç¨³å®šæ€§ä¸ºåŸºç¡€ã€‚',
            card2Title: 'æ¸…æ™°æ‰§è¡Œ',
            card2Desc: 'è·¯çº¿å›¾ã€é‡Œç¨‹ç¢‘å’Œé¡¹ç›®æ²Ÿé€šæ¸…æ™°æ˜Žç¡®ï¼ŒåŠ å¿«ä¸šåŠ¡å†³ç­–ã€‚'
        },
        about: {
            badge: 'å…³äºŽæˆ‘ä»¬',
            title: 'PT Fluxa Tritama Indonesia è‡´åŠ›äºŽåŠ å¼ºå°åº¦å°¼è¥¿äºšä¼ä¸šçš„æ•°å­—åŒ–è½¬åž‹ã€‚',
            desc1: 'æˆ‘ä»¬æ˜¯ä¸€å®¶ IT å…¬å¸ï¼Œå¸®åŠ©ç»„ç»‡è®¾è®¡ã€æž„å»ºå¹¶ç®¡ç†çœŸæ­£æœåŠ¡äºŽè¿è¥å’Œä¸šåŠ¡å¢žé•¿çš„æŠ€æœ¯è§£å†³æ–¹æ¡ˆã€‚',
            desc2: 'æˆ‘ä»¬ä¸“æ³¨äºŽäº¤ä»˜è´¨é‡ã€æµç¨‹æ¸…æ™°åº¦ä»¥åŠè´´è¿‘å®žé™…éœ€æ±‚çš„è§£å†³æ–¹æ¡ˆï¼Œä»Žå†…éƒ¨åº”ç”¨åˆ°ä¼ä¸šçº§åŸºç¡€è®¾æ–½ã€‚',
            card1Title: 'ä¸šåŠ¡å¯¼å‘å»ºè®¾',
            card1Desc: 'æ¯é¡¹è§£å†³æ–¹æ¡ˆéƒ½å›´ç»•å…·ä½“ä¸šåŠ¡æµç¨‹ã€æ•ˆçŽ‡ç›®æ ‡å’Œè¿è¥éœ€æ±‚æ¥è®¾è®¡ã€‚',
            card2Title: 'ç»“æž„åŒ–äº¤ä»˜',
            card2Desc: 'é¡¹ç›®æµç¨‹å¯è¡¡é‡ã€è¿›åº¦é€æ˜Žï¼Œæ›´å®¹æ˜“è¢«æŽ§åˆ¶ã€‚',
            card3Title: 'å¯æ‰©å±•åŸºç¡€',
            card3Desc: 'åŸºç¡€è®¾æ–½ä¸Žç³»ç»ŸæŒ‰ç…§æœªæ¥ä¸šåŠ¡å¢žé•¿éœ€æ±‚è¿›è¡Œè®¾è®¡ã€‚',
            card4Title: 'é•¿æœŸæ”¯æŒ',
            card4Desc: 'æˆ‘ä»¬ä¸ä¼šåœ¨ä¸Šçº¿åŽåœæ­¢ï¼ŒæŒç»­æ”¯æŒè®©ç³»ç»Ÿä¿æŒå¥åº·ä¸Žé€‚ç”¨ã€‚'
        },
        vision: {
            badge: 'æ„¿æ™¯ä¸Žä½¿å‘½',
            title: 'PT Fluxa Tritama Indonesia åœ¨æ‰“é€ ç›¸å…³ä¸”æœ‰ä»·å€¼æ•°å­—è§£å†³æ–¹æ¡ˆæ–¹é¢çš„æˆ˜ç•¥æ–¹å‘ã€‚',
            visionLabel: 'æ„¿æ™¯',
            visionText: 'æˆä¸ºä¸€å®¶å€¼å¾—ä¿¡èµ–çš„ç§‘æŠ€å…¬å¸ï¼Œä»¥åˆ›æ–°ã€é€‚åº”æ€§å¼ºä¸”æœ‰ä»·å€¼çš„æ•°å­—è§£å†³æ–¹æ¡ˆæ”¯æŒä¼ä¸šåœ¨æ•°å­—æ—¶ä»£çš„æˆé•¿ã€‚',
            missionLabel: 'ä½¿å‘½',
            mission1Title: 'å¼€å‘åˆ‡å®žå¯ç”¨çš„æ•°å­—è§£å†³æ–¹æ¡ˆ',
            mission1Desc: 'å»ºè®¾ç¬¦åˆå®¢æˆ·ä¸šåŠ¡éœ€æ±‚çš„ç½‘ç«™ã€åº”ç”¨ç¨‹åºã€ä¿¡æ¯ç³»ç»Ÿå’ŒæŠ€æœ¯æœåŠ¡ã€‚',
            mission2Title: 'æä¾›ä¸“ä¸šä¸”å¯æŒç»­çš„æœåŠ¡',
            mission2Desc: 'ä¿æŒå·¥ä½œè´¨é‡ã€æ²Ÿé€šä¸ŽæŠ€æœ¯æ”¯æŒï¼Œä½¿æ¯é¡¹è§£å†³æ–¹æ¡ˆéƒ½èƒ½è¢«æœ€ä½³ä½¿ç”¨ã€‚',
            mission3Title: 'æŽ¨åŠ¨ä¼ä¸šæ•°å­—åŒ–è½¬åž‹',
            mission3Desc: 'å¸®åŠ©ä¼ä¸šã€ç»„ç»‡å’Œæœºæž„é€šè¿‡æŠ€æœ¯æå‡æ•ˆçŽ‡ã€‚',
            mission4Title: 'ä¼˜å…ˆè€ƒè™‘åˆ›æ–°ä¸Žå¯é æ€§',
            mission4Desc: 'æä¾›çŽ°ä»£ã€å®‰å…¨ã€æ˜“ç”¨ä¸”å¯æ ¹æ®æœªæ¥éœ€æ±‚æŒç»­æ‰©å±•çš„ç³»ç»Ÿã€‚',
            mission5Title: 'é€šè¿‡æ¯ä¸ªè§£å†³æ–¹æ¡ˆåˆ›é€ ä»·å€¼',
            mission5Desc: 'è®©æ¯ä¸ªæƒ³æ³•ã€æµç¨‹å’ŒæŠ€æœ¯éƒ½æˆä¸ºèƒ½ä¸ºç”¨æˆ·å’Œå®¢æˆ·å¸¦æ¥çœŸå®žä»·å€¼çš„æˆæžœã€‚'
        },
        services: {
            badge: 'æœåŠ¡',
            title: 'ä¸ºè¿è¥éœ€æ±‚ä¸Žä¸šåŠ¡å¢žé•¿è€Œè®¾è®¡çš„ IT è§£å†³æ–¹æ¡ˆã€‚',
            desc: 'æˆ‘ä»¬ç»“åˆè½¯ä»¶å¼€å‘ã€åŸºç¡€è®¾æ–½å»ºè®¾ä¸Žå®žæ–½å’¨è¯¢ï¼Œå¸®åŠ©ä¼ä¸šæ›´é«˜æ•ˆè¿ä½œã€‚',
            card1Title: 'åº”ç”¨å¼€å‘',
            card1Desc: 'å¼€å‘ Webã€ç§»åŠ¨ç«¯åŠå†…éƒ¨ç³»ç»Ÿï¼Œç”¨äºŽæ•°å­—åŒ–ä¸šåŠ¡æµç¨‹ä¸Žå®¢æˆ·æœåŠ¡ã€‚',
            card2Title: 'åŸºç¡€è®¾æ–½ä¸Žç½‘ç»œ',
            card2Desc: 'è§„åˆ’å¹¶å®žæ–½å®‰å…¨ç¨³å®šçš„ IT åŸºç¡€è®¾æ–½ã€ç½‘ç»œä¸Žè¿è¥çŽ¯å¢ƒã€‚',
            card3Title: 'IT é‡‡è´­',
            card3Desc: 'ä»¥é«˜æ•ˆä¸”åŠ¡å®žçš„æ–¹å¼é‡‡è´­ç¡¬ä»¶ã€è½¯ä»¶åŠå…¶ä»–æŠ€æœ¯éœ€æ±‚ã€‚'
        },
        industries: {
            badge: 'æœåŠ¡è¡Œä¸š',
            title: 'é€‚ç”¨äºŽå¤šç§ç»„ç»‡ç±»åž‹å’Œ IT å®žæ–½éœ€æ±‚ã€‚',
            desc: 'æˆ‘ä»¬çš„æ–¹æ³•çµæ´»ï¼Œé€‚åˆä¼˜åŒ–å†…éƒ¨æµç¨‹ã€å»ºè®¾æ•°å­—äº§å“æˆ–å¼ºåŒ–åŸºç¡€è®¾æ–½çš„ä¼ä¸šã€‚',
            card1Title: 'ä¼ä¸šä¸Žä¸­å°ä¼ä¸š',
            card1Desc: 'æµç¨‹æ•°å­—åŒ–ã€è¿è¥çœ‹æ¿ä¸Žå†³ç­–æ”¯æŒç³»ç»Ÿã€‚',
            card2Title: 'é›¶å”®ä¸Žåˆ†é”€',
            card2Desc: 'é”€å”®ã€åº“å­˜ã€æŠ¥è¡¨åŠé—¨åº—æ´»åŠ¨ç›‘æŽ§æ•´åˆã€‚',
            card3Title: 'æ•™è‚²ä¸Žå…¬å…±æœåŠ¡',
            card3Desc: 'ä¿¡æ¯ç³»ç»Ÿã€æœåŠ¡é—¨æˆ·ä¸Žæ›´æœ‰åºçš„æ•°æ®æ²»ç†ã€‚',
            card4Title: 'å·¥ä¸šè¿è¥',
            card4Desc: 'ç½‘ç»œã€ç›‘æŽ§åŠçŽ°åœºè¿è¥æ”¯æŒæ–¹æ¡ˆã€‚'
        },
        portfolio: {
            badge: 'èƒ½åŠ›å±•ç¤º',
            title: 'æˆ‘ä»¬å¯ä¸ºæ‚¨çš„ä¼ä¸šæä¾›çš„è§£å†³æ–¹æ¡ˆæ–¹å‘ç¤ºä¾‹ã€‚',
            card1Title: 'ç®¡ç†é©¾é©¶èˆ±',
            card1Desc: 'ç´§å‡‘åž‹ä»ªè¡¨æ¿ï¼Œç”¨äºŽç›‘æŽ§ KPIã€è¿è¥ã€é”€å”®å’Œè·¨éƒ¨é—¨å…³é”®æ•°æ®ã€‚',
            card2Title: 'é¢å‘å®¢æˆ·çš„åº”ç”¨',
            card2Desc: 'å¸®åŠ©ä¼ä¸šæå‡å®¢æˆ·æœåŠ¡ä¸Žæ•°å­—ä½“éªŒçš„åº”ç”¨å’Œé—¨æˆ·ã€‚',
            card3Title: 'åŸºç¡€è®¾æ–½çŽ°ä»£åŒ–',
            card3Desc: 'å‡çº§ç½‘ç»œã€æœåŠ¡å™¨å’Œ IT çŽ¯å¢ƒï¼Œä½¿å…¶æ›´å®‰å…¨ã€æ›´æœ‰åºå¹¶å…·å¤‡å¢žé•¿èƒ½åŠ›ã€‚'
        },
        process: {
            badge: 'å·¥ä½œæµç¨‹',
            title: 'æˆ‘ä»¬å¦‚ä½•ç¡®ä¿æ¯ä¸ªé¡¹ç›®éƒ½æ¸…æ™°ã€æœ‰æ–¹å‘å¹¶å¯äº¤ä»˜ã€‚',
            desc: 'ç»“æž„åŒ–æµç¨‹å¯å‡å°‘æ²Ÿé€šåå·®ã€åŠ å¿«éªŒè¯å¹¶ä¿æŒå®žæ–½è´¨é‡ã€‚',
            step1Title: 'éœ€æ±‚å‘çŽ°ä¸Žæ¢³ç†',
            step1Desc: 'åœ¨æ‰§è¡Œå‰ï¼Œæˆ‘ä»¬å…ˆæ¢³ç†ä¸šåŠ¡éœ€æ±‚ã€çŽ°æœ‰æµç¨‹å’Œå®žæ–½ç›®æ ‡ã€‚',
            step2Title: 'æ–¹æ¡ˆè®¾è®¡',
            step2Desc: 'æ–¹æ¡ˆæž¶æž„ã€å·¥ä½œæµç¨‹å’Œå®žæ–½ä¼˜å…ˆçº§å‡ä¸Žä¸šåŠ¡éœ€æ±‚ä¿æŒä¸€è‡´ã€‚',
            step3Title: 'å»ºè®¾ä¸Žå®žæ–½',
            step3Desc: 'å›¢é˜Ÿä»¥å¯è¡¡é‡ä¸”æœ‰æ–‡æ¡£è®°å½•çš„æ–¹å¼å¼€å±•å¼€å‘ã€éƒ¨ç½²å’Œé…ç½®å·¥ä½œã€‚',
            step4Title: 'æµ‹è¯•ã€äº¤ä»˜ä¸Žæ”¯æŒ',
            step4Desc: 'æ–¹æ¡ˆç»è¿‡éªŒè¯åŽæ¸…æ™°äº¤ä»˜ï¼Œå¹¶æä¾›æ”¯æŒä»¥ç¡®ä¿çœŸå®žè¿è¥ä¸­çš„ç¨³å®šæ€§ã€‚'
        },
        contact: {
            badge: 'è”ç³»',
            title: 'æ‰“é€ æ›´ä¸“ä¸šçš„ä¼ä¸šå®˜ç½‘ä¸Žæ•°å­—ç³»ç»Ÿï¼Œæå‡æ½œåœ¨å®¢æˆ·å¯¹æ‚¨çš„ä¿¡ä»»ã€‚',
            desc: 'å¦‚æžœæ‚¨éœ€è¦ä¼ä¸šå®˜ç½‘ã€å†…éƒ¨åº”ç”¨æˆ–æ›´æ•´æ´çš„ IT åŸºç¡€è®¾æ–½ï¼Œæˆ‘ä»¬å¯ä»¥ä»Žè§„åˆ’åˆ°å®žæ–½å…¨ç¨‹ååŠ©ã€‚',
            cta1: 'WhatsApp å’¨è¯¢',
            cta2: 'å‘é€é‚®ä»¶',
            card1: 'é‚®ç®±',
            card2: 'ç”µè¯ / WhatsApp',
            card3: 'ä½ç½®',
            location: 'åŠ é‡Œæ›¼ä¸¹ï¼Œå°åº¦å°¼è¥¿äºš'
        },
        clients: { title: 'å®¢æˆ·' },
        footer: {
            taglinePrefix: 'PT Fluxa Tritama Indonesia ä¸ºçŽ°ä»£å•†ä¸šéœ€æ±‚æä¾›æŠ€æœ¯æœåŠ¡ä¸Žæ•°å­—è§£å†³æ–¹æ¡ˆ',
            taglineSuffix: 'ã€‚',
            copySuffix: 'ç‰ˆæƒæ‰€æœ‰ã€‚'
        }
    }
};

const chartCopy = {
    id: {
        labels: ['Q1', 'Q2', 'Q3', 'Q4'],
        lineLabel: 'Delivery Growth',
        doughnutLabel: 'Service Mix',
        doughnutData: [42, 33, 25]
    },
    en: {
        labels: ['Q1', 'Q2', 'Q3', 'Q4'],
        lineLabel: 'Delivery Growth',
        doughnutLabel: 'Service Mix',
        doughnutData: [42, 33, 25]
    },
    zh: {
        labels: ['Q1', 'Q2', 'Q3', 'Q4'],
        lineLabel: 'Delivery Growth',
        doughnutLabel: 'Service Mix',
        doughnutData: [42, 33, 25]
    }
};

const chatbotReplies = {
    id: {
        layanan: 'Kami menangani pengembangan website company profile, aplikasi web dan mobile, sistem internal, infrastruktur jaringan, serta IT procurement.',
        website: 'Bisa. Kami bisa membuat website company profile, landing page pemasaran, portal layanan, sampai dashboard internal yang terhubung ke proses bisnis.',
        konsultasi: 'Anda bisa mulai dari tombol WhatsApp atau email di section kontak. Untuk demo ini, alur idealnya dimulai dari diskusi kebutuhan, scope, lalu estimasi implementasi.',
        default: 'Bisa. Untuk demo ini saya sarankan arahkan pengunjung ke konsultasi awal, jelaskan kebutuhan bisnis, lalu tim PT Fluxa Tritama Indonesia menyiapkan solusi yang relevan.'
    },
    en: {
        layanan: 'We handle company profile websites, web and mobile applications, internal systems, network infrastructure, and IT procurement.',
        website: 'Yes. We can build company profile websites, marketing landing pages, service portals, and internal dashboards connected to business workflows.',
        konsultasi: 'You can start from the WhatsApp or email buttons in the contact section. In this demo flow, the ideal step is need discovery, scope discussion, then implementation estimate.',
        default: 'Yes. For this demo, the best path is to guide visitors into an initial consultation so the team can map needs and propose a relevant solution.'
    },
    zh: {
        layanan: 'æˆ‘ä»¬æä¾›ä¼ä¸šå®˜ç½‘ã€Web ä¸Žç§»åŠ¨åº”ç”¨ã€å†…éƒ¨ç³»ç»Ÿã€ç½‘ç»œåŸºç¡€è®¾æ–½ä»¥åŠ IT é‡‡è´­æœåŠ¡ã€‚',
        website: 'å¯ä»¥ã€‚æˆ‘ä»¬å¯ä»¥æž„å»ºä¼ä¸šå®˜ç½‘ã€è¥é”€è½åœ°é¡µã€æœåŠ¡é—¨æˆ·ä»¥åŠä¸Žä¸šåŠ¡æµç¨‹è¿žæŽ¥çš„å†…éƒ¨ä»ªè¡¨æ¿ã€‚',
        konsultasi: 'æ‚¨å¯ä»¥é€šè¿‡è”ç³»éƒ¨åˆ†çš„ WhatsApp æˆ–ç”µå­é‚®ä»¶å¼€å§‹ã€‚æ¼”ç¤ºæµç¨‹å»ºè®®ä»Žéœ€æ±‚æ²Ÿé€šã€èŒƒå›´ç¡®è®¤åˆ°å®žæ–½ä¼°ç®—ã€‚',
        default: 'å¯ä»¥ã€‚è¿™ä¸ªæ¼”ç¤ºèŠå¤©æœºå™¨äººç”¨äºŽå¼•å¯¼è®¿å®¢è¿›å…¥åˆæ­¥å’¨è¯¢ï¼Œå†ç”±å›¢é˜Ÿæ•´ç†éœ€æ±‚å¹¶æä¾›åˆé€‚æ–¹æ¡ˆã€‚'
    }
};

const getTranslation = (lang, key) => {
    return key.split('.').reduce((result, segment) => result?.[segment], translations[lang]);
};

const getChartTheme = () => {
    return body.dataset.theme === 'light'
        ? {
            tick: '#475569',
            grid: 'rgba(14, 74, 124, 0.12)',
            line: '#0f766e',
            bar: '#38bdf8',
            doughnut: ['#0f766e', '#38bdf8', '#f59e0b']
        }
        : {
            tick: '#b7c6da',
            grid: 'rgba(125, 211, 252, 0.12)',
            line: '#5eead4',
            bar: '#38bdf8',
            doughnut: ['#5eead4', '#38bdf8', '#f59e0b']
        };
};

const renderServicesChart = () => {
    if (!servicesChartCanvas || typeof Chart === 'undefined') {
        return;
    }

    const copy = chartCopy[currentLanguage] || chartCopy.id;
    const theme = getChartTheme();

    if (servicesChart) {
        servicesChart.destroy();
    }

    servicesChart = new Chart(servicesChartCanvas, {
        type: 'bar',
        data: {
            labels: copy.labels,
            datasets: [
                {
                    type: 'line',
                    label: copy.lineLabel,
                    data: [22, 35, 48, 63],
                    borderColor: theme.line,
                    backgroundColor: 'transparent',
                    tension: 0.35,
                    borderWidth: 3,
                    pointRadius: 4,
                    pointBackgroundColor: theme.line
                },
                {
                    label: copy.doughnutLabel,
                    data: [42, 55, 61, 74],
                    backgroundColor: theme.bar,
                    borderRadius: 12,
                    maxBarThickness: 42
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        color: theme.tick
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: theme.tick
                    },
                    grid: {
                        color: theme.grid
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: theme.tick
                    },
                    grid: {
                        color: theme.grid
                    }
                }
            }
        }
    });
};

const appendChatbotMessage = (message, type) => {
    if (!chatbotMessages) {
        return;
    }

    const bubble = document.createElement('div');
    bubble.className = `chatbot-bubble ${type === 'user' ? 'chatbot-bubble-user' : 'chatbot-bubble-bot'}`;
    bubble.textContent = message;
    chatbotMessages.appendChild(bubble);
    chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
};

const getChatbotReply = (input) => {
    const normalized = input.toLowerCase();
    const replies = chatbotReplies[currentLanguage] || chatbotReplies.id;

    if (normalized.includes('layanan') || normalized.includes('service')) {
        return replies.layanan;
    }

    if (normalized.includes('website') || normalized.includes('web')) {
        return replies.website;
    }

    if (normalized.includes('konsult') || normalized.includes('contact') || normalized.includes('meeting')) {
        return replies.konsultasi;
    }

    return replies.default;
};

const setChatbotPlaceholder = () => {
    if (!chatbotInput) {
        return;
    }

    const placeholders = {
        id: 'Tulis pertanyaan Anda...',
        en: 'Type your question...',
        zh: 'è¯·è¾“å…¥æ‚¨çš„é—®é¢˜...'
    };

    chatbotInput.placeholder = placeholders[currentLanguage] || placeholders.id;
};

const applyTheme = (theme) => {
    body.dataset.theme = theme;

    logoImages.forEach((logo) => {
        const nextSrc = theme === 'light' ? logo.dataset.logoLight : logo.dataset.logoDark;
        if (nextSrc) {
            logo.src = nextSrc;
        }
    });

    renderServicesChart();
    window.localStorage.setItem('fluxa-theme', theme);
};

const applyLanguage = (lang) => {
    const activeLang = translations[lang] ? lang : 'id';
    currentLanguage = activeLang;
    document.documentElement.lang = activeLang;

    document.querySelectorAll('[data-i18n]').forEach((element) => {
        const nextValue = getTranslation(activeLang, element.dataset.i18n);
        if (nextValue) {
            element.textContent = nextValue;
        }
    });

    if (pageTitle) {
        pageTitle.textContent = translations[activeLang].title;
        document.title = translations[activeLang].title;
    }

    if (pageDescription) {
        pageDescription.setAttribute('content', translations[activeLang].description);
    }

    if (ogTitle) {
        ogTitle.setAttribute('content', translations[activeLang].title);
    }

    if (ogDescription) {
        ogDescription.setAttribute('content', translations[activeLang].description);
    }

    if (twitterTitle) {
        twitterTitle.setAttribute('content', translations[activeLang].title);
    }

    if (twitterDescription) {
        twitterDescription.setAttribute('content', translations[activeLang].description);
    }

    langButtons.forEach((button) => {
        button.classList.toggle('is-active', button.dataset.lang === activeLang);
    });

    setChatbotPlaceholder();
    renderServicesChart();
    window.localStorage.setItem('fluxa-language', activeLang);
};

const toggleTheme = () => {
    const nextTheme = body.dataset.theme === 'light' ? 'dark' : 'light';
    applyTheme(nextTheme);
};

const savedTheme = window.localStorage.getItem('fluxa-theme');
if (savedTheme === 'light' || savedTheme === 'dark') {
    applyTheme(savedTheme);
}

const savedLanguage = window.localStorage.getItem('fluxa-language');
applyLanguage(savedLanguage || 'id');

if (year) {
    year.textContent = new Date().getFullYear();
}

mobileMenuBtn?.addEventListener('click', () => {
    mobileMenu?.classList.toggle('hidden');
});

themeToggle?.addEventListener('click', toggleTheme);
themeToggleMobile?.addEventListener('click', toggleTheme);

langButtons.forEach((button) => {
    button.addEventListener('click', () => {
        applyLanguage(button.dataset.lang);
    });
});

document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener('click', function(event) {
        event.preventDefault();
        const targetSelector = this.getAttribute('href');
        const target = targetSelector ? document.querySelector(targetSelector) : null;

        if (target) {
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            mobileMenu?.classList.add('hidden');
        }
    });
});

chatbotToggle?.addEventListener('click', () => {
    chatbotPanel?.classList.toggle('hidden');
});

chatbotClose?.addEventListener('click', () => {
    chatbotPanel?.classList.add('hidden');
});

chatbotQuickButtons.forEach((button) => {
    button.addEventListener('click', () => {
        const prompt = button.dataset.chatbotPrompt || '';
        appendChatbotMessage(button.textContent || prompt, 'user');
        appendChatbotMessage(getChatbotReply(prompt), 'bot');
    });
});

chatbotForm?.addEventListener('submit', (event) => {
    event.preventDefault();

    const prompt = chatbotInput?.value.trim();
    if (!prompt) {
        return;
    }

    appendChatbotMessage(prompt, 'user');
    appendChatbotMessage(getChatbotReply(prompt), 'bot');
    chatbotInput.value = '';
});

renderServicesChart();
setChatbotPlaceholder();

