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
            badge: 'IT Solutions for Growing Business',
            title1: 'Solusi IT profesional untuk bisnis yang ingin',
            title2: 'tumbuh lebih cepat dan lebih terstruktur.',
            desc: 'PT Fluxa Tritama Indonesia membantu perusahaan membangun sistem digital, aplikasi bisnis, dan infrastruktur IT yang aman, efisien, serta mudah dikembangkan.',
            ctaPrimary: 'Diskusikan Kebutuhan',
            ctaSecondary: 'Lihat Layanan',
            chip1: 'Aplikasi Web & Mobile',
            chip2: 'Infrastruktur & Jaringan',
            chip4: 'Otomasi Bisnis'
        },
        snapshot: {
            badge: 'Company Snapshot',
            title: 'Why PT Fluxa Tritama Indonesia',
            metric1: 'Inisiatif digital dan implementasi IT',
            metric2: 'Klien dari berbagai sektor bisnis',
            metric3: 'Tahun pengalaman delivery project',
            metric4: 'Dukungan untuk operasional penting',
            desc: 'Kami fokus pada hasil bisnis: sistem yang stabil, workflow yang lebih cepat, dan fondasi teknologi yang siap dipakai untuk scale-up.'
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
            desc: 'Kami merancang solusi digital dengan pendekatan visual, data, dan implementasi yang siap dipresentasikan ke calon klien maupun stakeholder internal.',
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
            title: 'Presentasi yang terlihat hidup dengan foto profesional dan video singkat yang langsung menjelaskan kapabilitas tim.',
            desc: 'Section ini membantu calon klien melihat suasana kerja, pendekatan delivery, dan kualitas visual brand dalam satu alur yang lebih meyakinkan.',
            card1Badge: 'Foto',
            card1Title: 'Corporate Tech Photo',
            card1Desc: 'Cocok untuk memperkuat persepsi profesional, modern, dan siap eksekusi.',
            card2Badge: 'Video',
            card2Title: 'Short Motion Demo',
            card2Desc: 'Memberi ritme visual yang lebih kuat dibanding section statis biasa.',
            videoCaption: 'Preview visual presentasi company profile'
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
            badge: 'IT Solutions for Growing Business',
            title1: 'Professional IT solutions for businesses that want to',
            title2: 'grow faster and operate with more structure.',
            desc: 'PT Fluxa Tritama Indonesia helps companies build digital systems, business applications, and IT infrastructure that are secure, efficient, and easy to scale.',
            ctaPrimary: 'Discuss Your Needs',
            ctaSecondary: 'View Services',
            chip1: 'Web & Mobile Apps',
            chip2: 'Infrastructure & Network',
            chip4: 'Business Automation'
        },
        snapshot: {
            badge: 'Company Snapshot',
            title: 'Why PT Fluxa Tritama Indonesia',
            metric1: 'Digital initiatives and IT implementations',
            metric2: 'Clients across multiple business sectors',
            metric3: 'Years of project delivery experience',
            metric4: 'Support for critical operations',
            desc: 'We focus on business outcomes: stable systems, faster workflows, and technology foundations that are ready to scale.'
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
            desc: 'We shape digital solutions with visuals, data, and implementation readiness so they present well to clients and internal stakeholders.',
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
            title: 'A more compelling presentation with professional photography and short video that immediately communicates team capability.',
            desc: 'This section helps prospective clients understand the working atmosphere, delivery approach, and brand quality in a more convincing flow.',
            card1Badge: 'Photo',
            card1Title: 'Corporate Tech Photo',
            card1Desc: 'Ideal for reinforcing a professional, modern, and execution-ready impression.',
            card2Badge: 'Video',
            card2Title: 'Short Motion Demo',
            card2Desc: 'Adds stronger visual rhythm than a fully static section.',
            videoCaption: 'Company profile visual preview'
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
        title: 'PT Fluxa Tritama Indonesia | 数字解决方案、应用开发与企业基础设施',
        description: 'PT Fluxa Tritama Indonesia 为印度尼西亚企业提供数字解决方案、Web 与移动应用开发、网络基础设施、IT 采购与数字化转型服务。',
        nav: { about: '关于我们', services: '服务', industries: '行业', projects: '项目', process: '流程', contact: '联系' },
        cta: { email: '发送邮件', consult: '咨询' },
        hero: {
            badge: '成长型企业的 IT 解决方案',
            title1: '为希望实现',
            title2: '更快增长与更高效率的企业提供专业 IT 解决方案。',
            desc: 'PT Fluxa Tritama Indonesia 帮助企业构建安全、高效且易于扩展的数字系统、业务应用和 IT 基础设施。',
            ctaPrimary: '沟通需求',
            ctaSecondary: '查看服务',
            chip1: 'Web 与移动应用',
            chip2: '基础设施与网络',
            chip4: '业务自动化'
        },
        snapshot: {
            badge: '公司概览',
            title: '为什么选择 PT Fluxa Tritama Indonesia',
            metric1: '数字化项目与 IT 实施',
            metric2: '来自多个行业的客户',
            metric3: '项目交付经验年限',
            metric4: '关键业务支持',
            desc: '我们专注于业务成果：稳定的系统、更快的流程，以及可支持企业扩张的技术基础。'
        },
        values: {
            badge: '核心价值',
            title: '我们不仅构建系统，更帮助企业更快推进业务。',
            card1Title: '安全与可靠',
            card1Desc: '架构与实施均以安全标准和运营稳定性为基础。',
            card2Title: '清晰执行',
            card2Desc: '路线图、里程碑和项目沟通清晰明确，加快业务决策。'
        },
        about: {
            badge: '关于我们',
            title: 'PT Fluxa Tritama Indonesia 致力于加强印度尼西亚企业的数字化转型。',
            desc1: '我们是一家 IT 公司，帮助组织设计、构建并管理真正服务于运营和业务增长的技术解决方案。',
            desc2: '我们专注于交付质量、流程清晰度以及贴近实际需求的解决方案，从内部应用到企业级基础设施。',
            card1Title: '业务导向建设',
            card1Desc: '每项解决方案都围绕具体业务流程、效率目标和运营需求来设计。',
            card2Title: '结构化交付',
            card2Desc: '项目流程可衡量、进度透明，更容易被控制。',
            card3Title: '可扩展基础',
            card3Desc: '基础设施与系统按照未来业务增长需求进行设计。',
            card4Title: '长期支持',
            card4Desc: '我们不会在上线后停止，持续支持让系统保持健康与适用。'
        },
        vision: {
            badge: '愿景与使命',
            title: 'PT Fluxa Tritama Indonesia 在打造相关且有价值数字解决方案方面的战略方向。',
            visionLabel: '愿景',
            visionText: '成为一家值得信赖的科技公司，以创新、适应性强且有价值的数字解决方案支持企业在数字时代的成长。',
            missionLabel: '使命',
            mission1Title: '开发切实可用的数字解决方案',
            mission1Desc: '建设符合客户业务需求的网站、应用程序、信息系统和技术服务。',
            mission2Title: '提供专业且可持续的服务',
            mission2Desc: '保持工作质量、沟通与技术支持，使每项解决方案都能被最佳使用。',
            mission3Title: '推动企业数字化转型',
            mission3Desc: '帮助企业、组织和机构通过技术提升效率。',
            mission4Title: '优先考虑创新与可靠性',
            mission4Desc: '提供现代、安全、易用且可根据未来需求持续扩展的系统。',
            mission5Title: '通过每个解决方案创造价值',
            mission5Desc: '让每个想法、流程和技术都成为能为用户和客户带来真实价值的成果。'
        },
        services: {
            badge: '服务',
            title: '为运营需求与业务增长而设计的 IT 解决方案。',
            desc: '我们结合软件开发、基础设施建设与实施咨询，帮助企业更高效运作。',
            card1Title: '应用开发',
            card1Desc: '开发 Web、移动端及内部系统，用于数字化业务流程与客户服务。',
            card2Title: '基础设施与网络',
            card2Desc: '规划并实施安全稳定的 IT 基础设施、网络与运营环境。',
            card3Title: 'IT 采购',
            card3Desc: '以高效且务实的方式采购硬件、软件及其他技术需求。'
        },
        industries: {
            badge: '服务行业',
            title: '适用于多种组织类型和 IT 实施需求。',
            desc: '我们的方法灵活，适合优化内部流程、建设数字产品或强化基础设施的企业。',
            card1Title: '企业与中小企业',
            card1Desc: '流程数字化、运营看板与决策支持系统。',
            card2Title: '零售与分销',
            card2Desc: '销售、库存、报表及门店活动监控整合。',
            card3Title: '教育与公共服务',
            card3Desc: '信息系统、服务门户与更有序的数据治理。',
            card4Title: '工业运营',
            card4Desc: '网络、监控及现场运营支持方案。'
        },
        portfolio: {
            badge: '能力展示',
            title: '我们可为您的企业提供的解决方案方向示例。',
            card1Title: '管理驾驶舱',
            card1Desc: '紧凑型仪表板，用于监控 KPI、运营、销售和跨部门关键数据。',
            card2Title: '面向客户的应用',
            card2Desc: '帮助企业提升客户服务与数字体验的应用和门户。',
            card3Title: '基础设施现代化',
            card3Desc: '升级网络、服务器和 IT 环境，使其更安全、更有序并具备增长能力。'
        },
        process: {
            badge: '工作流程',
            title: '我们如何确保每个项目都清晰、有方向并可交付。',
            desc: '结构化流程可减少沟通偏差、加快验证并保持实施质量。',
            step1Title: '需求发现与梳理',
            step1Desc: '在执行前，我们先梳理业务需求、现有流程和实施目标。',
            step2Title: '方案设计',
            step2Desc: '方案架构、工作流程和实施优先级均与业务需求保持一致。',
            step3Title: '建设与实施',
            step3Desc: '团队以可衡量且有文档记录的方式开展开发、部署和配置工作。',
            step4Title: '测试、交付与支持',
            step4Desc: '方案经过验证后清晰交付，并提供支持以确保真实运营中的稳定性。'
        },
        contact: {
            badge: '联系',
            title: '打造更专业的企业官网与数字系统，提升潜在客户对您的信任。',
            desc: '如果您需要企业官网、内部应用或更整洁的 IT 基础设施，我们可以从规划到实施全程协助。',
            cta1: 'WhatsApp 咨询',
            cta2: '发送邮件',
            card1: '邮箱',
            card2: '电话 / WhatsApp',
            card3: '位置',
            location: '加里曼丹，印度尼西亚'
        },
        clients: { title: '客户' },
        footer: {
            taglinePrefix: 'PT Fluxa Tritama Indonesia 为现代商业需求提供技术服务与数字解决方案',
            taglineSuffix: '。',
            copySuffix: '版权所有。'
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
        layanan: '我们提供企业官网、Web 与移动应用、内部系统、网络基础设施以及 IT 采购服务。',
        website: '可以。我们可以构建企业官网、营销落地页、服务门户以及与业务流程连接的内部仪表板。',
        konsultasi: '您可以通过联系部分的 WhatsApp 或电子邮件开始。演示流程建议从需求沟通、范围确认到实施估算。',
        default: '可以。这个演示聊天机器人用于引导访客进入初步咨询，再由团队整理需求并提供合适方案。'
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
        zh: '请输入您的问题...'
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
