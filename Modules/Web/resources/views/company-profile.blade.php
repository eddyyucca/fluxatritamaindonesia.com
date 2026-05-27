<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT Fluxa Tritama Indonesia | Solusi Digital & Infrastruktur Bisnis</title>
    <meta name="description" content="PT Fluxa Tritama Indonesia — solusi digital, pengembangan aplikasi web & mobile, infrastruktur jaringan, IT procurement, dan transformasi digital untuk bisnis Indonesia.">
    <meta name="robots" content="index, follow">
    <meta name="author" content="PT Fluxa Tritama Indonesia">
    <meta name="theme-color" content="#07111f">
    <meta property="og:type" content="website">
    <meta property="og:title" content="PT Fluxa Tritama Indonesia | Solusi Digital & Infrastruktur Bisnis">
    <meta property="og:description" content="Partner teknologi terpercaya untuk transformasi digital bisnis di Indonesia.">
    <meta property="og:image" content="{{ asset('assets/images/FLUXATRITAMAINDONESIA.png') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/favicon.ico') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --bg:#07111f; --bg2:#0d1b2e;
            --surface:rgba(255,255,255,0.04); --surface2:rgba(255,255,255,0.06);
            --border:rgba(255,255,255,0.08); --border2:rgba(255,255,255,0.12);
            --teal:#2dd4bf; --sky:#38bdf8; --blue:#60a5fa;
            --violet:#a78bfa; --amber:#fbbf24; --rose:#fb7185;
            --text1:#f1f5f9; --text2:#94a3b8; --text3:#64748b;
        }
        *{box-sizing:border-box;margin:0;padding:0}
        html{scroll-behavior:smooth}
        body{background:var(--bg);color:var(--text2);font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;overflow-x:hidden;line-height:1.7}

        /* grid bg */
        body::before{content:'';position:fixed;inset:0;background-image:linear-gradient(rgba(56,189,248,.025) 1px,transparent 1px),linear-gradient(90deg,rgba(56,189,248,.025) 1px,transparent 1px);background-size:48px 48px;pointer-events:none;z-index:0}

        /* reveal */
        .reveal{opacity:0;transform:translateY(28px);transition:opacity .7s cubic-bezier(.16,1,.3,1),transform .7s cubic-bezier(.16,1,.3,1)}
        .reveal-l{opacity:0;transform:translateX(-32px);transition:opacity .7s cubic-bezier(.16,1,.3,1),transform .7s cubic-bezier(.16,1,.3,1)}
        .reveal-r{opacity:0;transform:translateX(32px);transition:opacity .7s cubic-bezier(.16,1,.3,1),transform .7s cubic-bezier(.16,1,.3,1)}
        .reveal.on,.reveal-l.on,.reveal-r.on{opacity:1;transform:none}
        .d1{transition-delay:.1s!important}.d2{transition-delay:.2s!important}.d3{transition-delay:.3s!important}.d4{transition-delay:.4s!important}.d5{transition-delay:.5s!important}

        /* type */
        h1,h2,h3,h4{color:var(--text1);font-weight:700;letter-spacing:-.02em}
        .grad{background:linear-gradient(135deg,var(--teal),var(--sky),var(--blue));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
        .badge-lbl{display:inline-flex;align-items:center;gap:.5rem;font-size:.7rem;font-weight:600;letter-spacing:.2em;text-transform:uppercase;color:var(--sky);margin-bottom:1rem}
        .badge-lbl::before{content:'';width:1.5rem;height:2px;background:linear-gradient(90deg,var(--teal),var(--sky));border-radius:2px}

        /* glass */
        .glass{background:var(--surface);border:1px solid var(--border);backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px)}
        .glass2{background:var(--surface2);border:1px solid var(--border2);backdrop-filter:blur(24px);-webkit-backdrop-filter:blur(24px)}
        .hov-card{transition:border-color .3s,box-shadow .3s,transform .3s}
        .hov-card:hover{border-color:rgba(56,189,248,.3);box-shadow:0 0 32px rgba(56,189,248,.07),0 8px 32px rgba(0,0,0,.3);transform:translateY(-4px)}

        /* navbar */
        #nav{position:fixed;top:0;left:0;right:0;z-index:100;transition:background .3s,border-color .3s,backdrop-filter .3s;background:rgba(7,17,31,.6);backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px)}
        #nav.sc{background:rgba(7,17,31,.92);border-bottom:1px solid var(--border);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px)}
        .nl{position:relative;font-size:.875rem;color:var(--text2);transition:color .2s;padding:.25rem 0}
        .nl::after{content:'';position:absolute;bottom:-2px;left:0;width:0;height:2px;background:linear-gradient(90deg,var(--teal),var(--sky));border-radius:2px;transition:width .3s}
        .nl:hover{color:#fff}.nl:hover::after{width:100%}
        .btn-p{background:linear-gradient(135deg,var(--teal),var(--sky));color:#07111f;font-weight:700;border-radius:50px;padding:.6rem 1.4rem;font-size:.875rem;transition:opacity .2s,transform .15s,box-shadow .2s;box-shadow:0 0 20px rgba(56,189,248,.25)}
        .btn-p:hover{opacity:.9;transform:translateY(-1px);box-shadow:0 0 30px rgba(56,189,248,.4)}
        .btn-s{border:1px solid var(--border2);color:var(--text1);font-weight:600;border-radius:50px;padding:.6rem 1.4rem;font-size:.875rem;transition:border-color .2s,background .2s}
        .btn-s:hover{border-color:rgba(56,189,248,.4);background:rgba(56,189,248,.06)}

        /* mobile menu */
        #mob-menu{max-height:0;overflow:hidden;transition:max-height .5s cubic-bezier(.16,1,.3,1),opacity .4s;opacity:0;background:rgba(7,17,31,.97);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px)}
        #mob-menu.open{max-height:600px;opacity:1}
        .ham-ln{display:block;width:22px;height:2px;background:var(--text2);border-radius:2px;transition:transform .3s,opacity .3s}
        #ham.open .ham-ln:nth-child(1){transform:rotate(45deg) translate(4px,4px)}
        #ham.open .ham-ln:nth-child(2){opacity:0}
        #ham.open .ham-ln:nth-child(3){transform:rotate(-45deg) translate(4px,-4px)}
        #mob-menu a{color:rgba(148,163,184,.9)}
        #mob-menu a:hover{color:#fff;background:rgba(255,255,255,.05)}

        /* hero orbs & animations */
        .orb{position:absolute;border-radius:50%;filter:blur(90px);pointer-events:none}
        @keyframes float{0%,100%{transform:translateY(0) scale(1)}50%{transform:translateY(-18px) scale(1.04)}}
        @keyframes floatB{0%,100%{transform:translateY(0) rotate(0deg)}50%{transform:translateY(-10px) rotate(3deg)}}
        @keyframes pulse-r{0%,100%{transform:scale(.95);opacity:.7}50%{transform:scale(1.02);opacity:1}}
        @keyframes marquee{0%{transform:translateX(0)}100%{transform:translateX(-50%)}}
        @keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:none}}
        @keyframes blink{0%,100%{opacity:1}50%{opacity:0}}
        @keyframes shimmer{0%{background-position:-200% 0}100%{background-position:200% 0}}
        @keyframes spin-s{from{transform:rotate(0deg)}to{transform:rotate(360deg)}}
        .fl{animation:float 6s ease-in-out infinite}
        .fl-b{animation:floatB 8s ease-in-out infinite}
        .pr{animation:pulse-r 3s ease-in-out infinite}
        .sp{animation:spin-s 20s linear infinite}

        /* hero badge */
        .hero-badge{display:inline-flex;align-items:center;gap:.5rem;padding:.375rem 1rem;border-radius:50px;border:1px solid rgba(45,212,191,.2);background:rgba(45,212,191,.06);font-size:.7rem;font-weight:600;letter-spacing:.18em;text-transform:uppercase;color:#99f6e4;animation:fadeUp .8s ease both}
        .hero-badge .dot{width:5px;height:5px;border-radius:50%;background:rgba(45,212,191,.55);animation:pulse-r 3s ease-in-out infinite}

        /* metric pills */
        .m-pill{background:var(--surface);border:1px solid var(--border);border-radius:16px;padding:1.25rem 1rem;text-align:center;transition:border-color .3s,transform .3s}
        .m-pill:hover{border-color:rgba(56,189,248,.3);transform:translateY(-3px)}
        .m-pill .n{font-size:2rem;font-weight:800;color:#fff;line-height:1}
        .m-pill .l{font-size:.75rem;color:var(--text2);margin-top:.4rem;line-height:1.4}

        /* service cards */
        .svc{border-radius:24px;padding:2rem;border:1px solid var(--border);background:var(--surface);position:relative;overflow:hidden;transition:border-color .3s,transform .3s,box-shadow .3s}
        .svc::before{content:'';position:absolute;inset:-1px;border-radius:inherit;background:linear-gradient(135deg,rgba(45,212,191,.1),transparent 60%);opacity:0;transition:opacity .3s}
        .svc:hover{border-color:rgba(45,212,191,.3);transform:translateY(-6px);box-shadow:0 20px 60px rgba(0,0,0,.3)}
        .svc:hover::before{opacity:1}
        .svc-ic{width:56px;height:56px;border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:1.25rem;margin-bottom:1.5rem}
        .chip{display:inline-block;padding:.25rem .75rem;border-radius:50px;border:1px solid var(--border2);font-size:.7rem;color:var(--text2);background:rgba(255,255,255,.03)}

        /* step timeline */
        .step{position:relative;padding:1.75rem 1.75rem 1.75rem 5rem;border-radius:20px;border:1px solid var(--border);background:var(--surface);transition:border-color .3s,transform .3s}
        .step:hover{border-color:rgba(56,189,248,.25);transform:translateX(6px)}
        .step-n{position:absolute;left:1.25rem;top:1.75rem;width:2.25rem;height:2.25rem;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:800;color:#07111f}
        .step-ln{position:absolute;left:2.35rem;top:calc(1.75rem + 2.25rem);width:2px;height:calc(100% - 1.75rem - 2.25rem + 1.75rem + 8px);background:linear-gradient(to bottom,rgba(56,189,248,.4),transparent)}

        /* industry cards */
        .ind{padding:1.5rem;border-radius:20px;border:1px solid var(--border);background:var(--surface);transition:border-color .3s,transform .3s,background .3s}
        .ind:hover{border-color:rgba(167,139,250,.3);transform:translateY(-4px);background:rgba(167,139,250,.04)}
        .ind-ic{width:48px;height:48px;border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;font-size:1.1rem}

        /* contact */
        .ct-item{display:flex;align-items:flex-start;gap:1rem;padding:1.25rem;border-radius:16px;border:1px solid var(--border);background:var(--surface);transition:border-color .3s}
        .ct-item:hover{border-color:rgba(56,189,248,.25)}

        /* marquee */
        .mq-wrap{overflow:hidden;position:relative}
        .mq-wrap::before,.mq-wrap::after{content:'';position:absolute;top:0;bottom:0;width:120px;z-index:2}
        .mq-wrap::before{left:0;background:linear-gradient(to right,var(--bg),transparent)}
        .mq-wrap::after{right:0;background:linear-gradient(to left,var(--bg),transparent)}
        .mq-track{display:flex;width:max-content;animation:marquee 28s linear infinite}
        .mq-track:hover{animation-play-state:paused}
        .mq-logo{height:40px;width:auto;max-width:130px;object-fit:contain;filter:brightness(.9);transition:filter .3s;margin:0 2.5rem}
        .mq-logo:hover{filter:brightness(1.1)}

        /* chart */
        .chart-wrap{position:relative;height:280px;min-height:0;width:100%}

        /* chatbot */
        .cb-fab{position:fixed;bottom:1.5rem;right:1.5rem;z-index:90;width:48px;height:48px;border-radius:50%;background:linear-gradient(135deg,var(--teal),var(--sky));color:#07111f;font-size:1.1rem;display:flex;align-items:center;justify-content:center;box-shadow:0 6px 20px rgba(56,189,248,.35);cursor:pointer;border:none;transition:transform .2s,box-shadow .2s}
        .cb-fab:hover{transform:scale(1.08);box-shadow:0 10px 28px rgba(56,189,248,.5)}
        .cb-panel{position:fixed;bottom:4.25rem;right:1.5rem;z-index:90;width:300px;border-radius:16px;border:1px solid var(--border2);background:#0d1b2e;box-shadow:0 20px 50px rgba(0,0,0,.5);display:flex;flex-direction:column;overflow:hidden;transform:scale(.92) translateY(16px);opacity:0;pointer-events:none;transition:transform .3s cubic-bezier(.16,1,.3,1),opacity .3s}
        .cb-panel.open{transform:none;opacity:1;pointer-events:all}
        .cb-hdr{background:linear-gradient(135deg,rgba(45,212,191,.15),rgba(56,189,248,.1));padding:.75rem 1rem;border-bottom:1px solid var(--border)}
        .cb-msgs{flex:1;overflow-y:auto;padding:.75rem 1rem;max-height:180px;display:flex;flex-direction:column;gap:.5rem}
        .cb-bbl{max-width:88%;padding:.5rem .875rem;border-radius:12px;font-size:.75rem;line-height:1.5;white-space:pre-line}
        .bb-bot{align-self:flex-start;background:rgba(255,255,255,.06);border:1px solid var(--border);color:var(--text2);border-radius:4px 12px 12px 12px}
        .bb-usr{align-self:flex-end;background:linear-gradient(135deg,var(--teal),var(--sky));color:#07111f;font-weight:600;border-radius:12px 4px 12px 12px}
        .cb-quick{padding:.375rem 1rem;display:flex;flex-wrap:wrap;gap:.3rem;border-top:1px solid var(--border)}
        .cb-qbtn{padding:.25rem .625rem;border-radius:50px;border:1px solid var(--border2);background:var(--surface);color:var(--text2);font-size:.65rem;cursor:pointer;transition:border-color .2s,color .2s}
        .cb-qbtn:hover{border-color:rgba(56,189,248,.4);color:var(--sky)}
        .cb-form{display:flex;gap:.375rem;padding:.5rem 1rem;border-top:1px solid var(--border)}
        .cb-inp{flex:1;background:var(--surface);border:1px solid var(--border2);border-radius:50px;padding:.375rem .875rem;font-size:.75rem;color:var(--text1);outline:none;transition:border-color .2s}
        .cb-inp:focus{border-color:var(--sky)}
        .cb-send{width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,var(--teal),var(--sky));color:#07111f;font-size:.75rem;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:opacity .2s}
        .cb-send:hover{opacity:.85}

        /* lang */
        .lang-b{padding:.25rem .625rem;border-radius:6px;font-size:.7rem;font-weight:600;letter-spacing:.05em;color:var(--text3);border:1px solid transparent;cursor:pointer;background:transparent;transition:all .2s}
        .lang-b.active,.lang-b:hover{color:var(--sky);border-color:rgba(56,189,248,.3);background:rgba(56,189,248,.06)}

        /* theme toggle */
        .th-tog{width:36px;height:36px;border-radius:10px;border:1px solid var(--border2);background:var(--surface);color:var(--text2);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:border-color .2s,color .2s}
        .th-tog:hover{border-color:rgba(56,189,248,.3);color:var(--sky)}

        /* light theme */
        [data-theme=light]{--bg:#f0f4f8;--bg2:#e2e8f0;--surface:rgba(0,0,0,.04);--border:rgba(0,0,0,.08);--border2:rgba(0,0,0,.14);--text1:#0f172a;--text2:#334155;--text3:#64748b}
        [data-theme=light] body::before{background-image:linear-gradient(rgba(15,23,42,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(15,23,42,.04) 1px,transparent 1px)}
        [data-theme=light] #nav.sc{background:rgba(240,244,248,.9)}
        [data-theme=light] .cb-panel{background:#f8fafc}
        [data-theme=light] .bb-bot{background:rgba(0,0,0,.05);border-color:rgba(0,0,0,.1)}
        [data-theme=light] .logo-d{display:none!important}
        [data-theme=light] .logo-l{display:block!important}
        [data-theme=dark]  .logo-l{display:none!important}
        [data-theme=dark]  .logo-d{display:block!important}
        /* light mode text overrides — prevent white-on-light invisibility */
        [data-theme=light] .text-white{color:var(--text1)!important}
        [data-theme=light] .text-slate-200,[data-theme=light] .text-slate-300{color:var(--text2)!important}
        [data-theme=light] .text-slate-400{color:var(--text3)!important}
        [data-theme=light] .text-slate-500{color:#94a3b8!important}
        [data-theme=light] .nl:hover{color:var(--text1)}
        [data-theme=light] .nl::after{background:linear-gradient(90deg,var(--teal),#0ea5e9)}
        [data-theme=light] .btn-s{color:var(--text1);border-color:var(--border2)}
        [data-theme=light] .btn-s:hover{background:rgba(14,165,233,.1);border-color:rgba(14,165,233,.4)}
        [data-theme=light] .svc{background:rgba(255,255,255,.7)}
        [data-theme=light] .ind{background:rgba(255,255,255,.7)}
        [data-theme=light] .step{background:rgba(255,255,255,.7)}
        [data-theme=light] .ct-item{background:rgba(255,255,255,.7)}
        [data-theme=light] .m-pill{background:rgba(255,255,255,.7)}
        [data-theme=light] .chip{color:var(--text2);background:rgba(0,0,0,.06);border-color:var(--border2)}
        [data-theme=light] .mq-wrap::before{background:linear-gradient(to right,var(--bg),transparent)}
        [data-theme=light] .mq-wrap::after{background:linear-gradient(to left,var(--bg),transparent)}
        [data-theme=light] .mq-logo{filter:brightness(.85) contrast(1.1)}
        [data-theme=light] .mq-logo:hover{filter:brightness(1)}
        [data-theme=light] .cb-inp{background:#fff;border-color:var(--border2);color:var(--text1)}
        [data-theme=light] .cb-qbtn{background:rgba(255,255,255,.8);color:var(--text2)}
        [data-theme=light] .cb-hdr{background:linear-gradient(135deg,rgba(13,148,136,.12),rgba(14,165,233,.08))}
        [data-theme=light] #btt{background:rgba(255,255,255,.9)}
        [data-theme=light] .hero-badge{background:rgba(13,148,136,.08);border-color:rgba(13,148,136,.25);color:#0f766e}
        [data-theme=light] .hero-badge .dot{background:#0f766e}
        [data-theme=light] #nav{background:rgba(240,244,248,.82);backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px)}
        [data-theme=light] #nav.sc{background:rgba(240,244,248,.95)}
        [data-theme=light] #mob-menu{background:rgba(240,244,248,.98);border-color:var(--border)}
        [data-theme=light] #mob-menu a{color:var(--text2)!important}
        [data-theme=light] #mob-menu a:hover{color:var(--text1)!important}
        [data-theme=light] .glass{background:rgba(255,255,255,.6);border-color:var(--border2)}
        [data-theme=light] .glass2{background:rgba(255,255,255,.75);border-color:var(--border2)}
        [data-theme=light] .hov-card:hover{box-shadow:0 0 24px rgba(14,165,233,.12),0 8px 24px rgba(0,0,0,.08)}
        [data-theme=light] .orb{opacity:.04!important}
        [data-theme=light] body::before{opacity:.5}
        [data-theme=light] .text-slate-600{color:#64748b!important}
        [data-theme=light] .badge-lbl{color:#0ea5e9}
        [data-theme=light] .step:hover{border-color:rgba(14,165,233,.3)}
        [data-theme=light] .ind:hover{background:rgba(167,139,250,.06)}
        [data-theme=light] .gl{background:linear-gradient(to right,transparent,var(--border2),transparent)}

        /* grad line */
        .gl{height:1px;background:linear-gradient(to right,transparent,var(--border2),transparent)}

        /* back to top — sits above the chatbot FAB with clear gap */
        #btt{position:fixed;bottom:calc(1.5rem + 48px + 0.75rem);right:1.5rem;z-index:89;width:36px;height:36px;border-radius:50%;background:var(--surface);border:1px solid var(--border2);color:var(--text2);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:opacity .3s,transform .3s,border-color .2s,color .2s;opacity:0;transform:translateY(8px);pointer-events:none;backdrop-filter:blur(10px);-webkit-backdrop-filter:blur(10px)}
        #btt.show{opacity:1;transform:none;pointer-events:all}
        #btt:hover{border-color:rgba(56,189,248,.4);color:var(--sky)}

        /* scrollbar */
        ::-webkit-scrollbar{width:5px}
        ::-webkit-scrollbar-track{background:transparent}
        ::-webkit-scrollbar-thumb{background:rgba(56,189,248,.2);border-radius:3px}

        /* progress bar */
        #progress{position:fixed;top:0;left:0;z-index:200;height:2px;background:linear-gradient(90deg,var(--teal),var(--sky));width:0%;transition:width .1s linear}

        @media(max-width:640px){
            .cb-panel{width:calc(100vw - 3rem);right:1rem}
            .cb-fab{bottom:1.25rem;right:1rem}
            #btt{bottom:calc(1.25rem + 48px + 0.75rem);right:1rem}
            .chart-wrap{height:220px}
        }
        @media(max-width:1024px){
            .chart-wrap{height:240px}
        }
    </style>
</head>
<body data-theme="dark">
<div id="progress"></div>
<div class="relative z-10">

<!-- ══════════════════════════════════ NAV ══ -->
<nav id="nav">
    <div class="max-w-7xl mx-auto px-5 sm:px-8">
        <div class="flex h-[70px] items-center justify-between">

            <a href="#home" class="flex-shrink-0">
                <img src="{{ asset('assets/images/logo-white-transparent.png') }}" alt="Fluxa" class="h-9 logo-d">
                <img src="{{ asset('assets/images/logo-black-transparent.png') }}" alt="Fluxa" class="h-9 logo-l" style="display:none">
            </a>

            <div class="hidden lg:flex items-center gap-8">
                <a href="#about"      class="nl" data-i18n="nav.about">Tentang</a>
                <a href="#services"   class="nl" data-i18n="nav.services">Layanan</a>
                <a href="#industries" class="nl" data-i18n="nav.industries">Industri</a>
                <a href="#portfolio"  class="nl" data-i18n="nav.projects">Proyek</a>
                <a href="#process"    class="nl" data-i18n="nav.process">Proses</a>
                <a href="#contact"    class="nl" data-i18n="nav.contact">Kontak</a>
                <a href="/career/login" class="nl">Karir</a>
            </div>

            <div class="hidden lg:flex items-center gap-3">
                <div class="flex gap-1">
                    <button class="lang-b active" data-lang="id">ID</button>
                    <button class="lang-b" data-lang="en">EN</button>
                    <button class="lang-b" data-lang="zh">中文</button>
                </div>
                <button id="th-tog" class="th-tog"><i class="fas fa-moon text-sm" id="th-ic"></i></button>
                <a href="mailto:official@fluxa.co.id" class="btn-s" data-i18n="cta.email">Email Kami</a>
                <a href="https://wa.me/6281250653005" class="btn-p" data-i18n="cta.consult">Konsultasi</a>
            </div>

            <div class="flex lg:hidden items-center gap-2">
                <button id="th-tog-m" class="th-tog"><i class="fas fa-moon text-sm" id="th-ic-m"></i></button>
                <button id="ham" class="flex flex-col gap-1.5 p-2" aria-label="Menu">
                    <span class="ham-ln"></span><span class="ham-ln"></span><span class="ham-ln"></span>
                </button>
            </div>
        </div>
    </div>

    <div id="mob-menu" class="lg:hidden border-t border-white/10">
        <div class="max-w-7xl mx-auto px-5 py-5 flex flex-col gap-4">
            <div class="flex flex-col gap-1">
                <a href="#about"      class="text-sm py-2.5 px-3 rounded-xl transition-colors" data-i18n="nav.about">Tentang</a>
                <a href="#services"   class="text-sm py-2.5 px-3 rounded-xl transition-colors" data-i18n="nav.services">Layanan</a>
                <a href="#industries" class="text-sm py-2.5 px-3 rounded-xl transition-colors" data-i18n="nav.industries">Industri</a>
                <a href="#portfolio"  class="text-sm py-2.5 px-3 rounded-xl transition-colors" data-i18n="nav.projects">Proyek</a>
                <a href="#process"    class="text-sm py-2.5 px-3 rounded-xl transition-colors" data-i18n="nav.process">Proses</a>
                <a href="#contact"    class="text-sm py-2.5 px-3 rounded-xl transition-colors" data-i18n="nav.contact">Kontak</a>
                <a href="/career/login" class="text-sm py-2.5 px-3 rounded-xl transition-colors">Karir</a>
            </div>
            <div class="flex gap-1.5 pt-3 border-t border-white/10">
                <button class="lang-b active flex-1 text-center" data-lang="id">ID</button>
                <button class="lang-b flex-1 text-center" data-lang="en">EN</button>
                <button class="lang-b flex-1 text-center" data-lang="zh">中文</button>
            </div>
            <div class="flex flex-col gap-2">
                <a href="mailto:official@fluxa.co.id" class="btn-s text-center py-3" data-i18n="cta.email">Email Kami</a>
                <a href="https://wa.me/6281250653005" class="btn-p text-center py-3" data-i18n="cta.consult">Konsultasi</a>
            </div>
        </div>
    </div>
</nav>

<!-- ══════════════════════════════════ HERO ══ -->
<section id="home" class="relative min-h-screen flex items-center pt-28 pb-20 overflow-hidden">
    <div class="orb w-[600px] h-[600px] bg-teal-500 opacity-[.07] -top-40 -left-40 pr"></div>
    <div class="orb w-[480px] h-[480px] bg-blue-600 opacity-[.06] top-10 right-0"></div>
    <div class="orb w-[320px] h-[320px] bg-violet-600 opacity-[.05] bottom-0 left-1/3 fl-b"></div>

    <div class="max-w-7xl mx-auto px-5 sm:px-8 w-full">
        <div class="grid lg:grid-cols-2 gap-16 items-center">

            <!-- copy -->
            <div>
                <div class="hero-badge mb-6"><span class="dot"></span><span data-i18n="hero.badge">Every Flow Builds The Future</span></div>
                <h1 class="text-4xl sm:text-5xl lg:text-[3.5rem] xl:text-[4rem] font-extrabold leading-[1.08] tracking-tight text-white" style="animation:fadeUp .9s .1s both">
                    <span data-i18n="hero.title1">Solusi IT Profesional untuk Bisnis yang Ingin</span><br>
                    <span class="grad" data-i18n="hero.title2">Tumbuh Lebih Cepat.</span>
                </h1>
                <p class="mt-6 text-base sm:text-lg leading-relaxed text-slate-300 max-w-xl" style="animation:fadeUp 1s .2s both" data-i18n="hero.desc">
                    PT Fluxa Tritama Indonesia membantu perusahaan membangun sistem digital, aplikasi bisnis, dan infrastruktur IT yang aman, efisien, serta siap dikembangkan.
                </p>
                <div class="mt-8 flex flex-col sm:flex-row gap-3" style="animation:fadeUp 1s .3s both">
                    <a href="#contact" class="btn-p text-center py-3.5 px-7" data-i18n="hero.ctaPrimary">Diskusikan Kebutuhan</a>
                    <a href="#services" class="btn-s text-center py-3.5 px-7" data-i18n="hero.ctaSecondary"><i class="fas fa-arrow-down mr-2 text-xs"></i>Lihat Layanan</a>
                </div>
                <div class="mt-7 flex flex-wrap gap-2" style="animation:fadeUp 1s .4s both">
                    <span class="chip">Web & Mobile App</span>
                    <span class="chip">Infrastructure & Network</span>
                    <span class="chip">IT Procurement</span>
                    <span class="chip">Business Automation</span>
                </div>
                <!-- stats -->
                <div class="mt-10 flex gap-8 pt-8 border-t border-white/[.07]" style="animation:fadeUp 1s .5s both">
                    <div><div class="text-2xl font-extrabold text-white counter" data-target="50">0+</div><div class="text-xs text-slate-400 mt-1" data-i18n="snapshot.metric1">Inisiatif Digital</div></div>
                    <div class="w-px bg-white/[.07]"></div>
                    <div><div class="text-2xl font-extrabold text-white counter" data-target="30">0+</div><div class="text-xs text-slate-400 mt-1" data-i18n="snapshot.metric2">Klien Aktif</div></div>
                    <div class="w-px bg-white/[.07]"></div>
                    <div><div class="text-2xl font-extrabold text-white counter" data-target="5">0+</div><div class="text-xs text-slate-400 mt-1" data-i18n="snapshot.metric3">Tahun Pengalaman</div></div>
                </div>
            </div>

            <!-- visual card -->
            <div class="fl hidden lg:block" style="animation:float 6s ease-in-out infinite,fadeUp 1s .3s both">
                <div class="glass2 rounded-[2rem] p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-teal-400 opacity-10 rounded-full -translate-y-16 translate-x-16 blur-3xl"></div>
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <p class="badge-lbl" data-i18n="snapshot.badge">Company Snapshot</p>
                            <h2 class="text-xl font-bold text-white leading-tight" data-i18n="snapshot.titleLine1">Why PT Fluxa Tritama Indonesia <span class="grad" data-i18n="snapshot.titleLine2">Tritama Indonesia</span></h2>
                        </div>
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center" style="background:rgba(45,212,191,.12)">
                            <i class="fas fa-chart-line text-teal-300"></i>
                        </div>
                    </div>
                    <div class="rounded-[1.5rem] overflow-hidden mb-5 relative">
                        <img src="{{ asset('assets/images/hero-team-photo.png') }}" alt="Tim PT Fluxa" class="w-full object-cover aspect-video">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent flex items-end p-4">
                            <span class="text-xs font-semibold text-white/80 backdrop-blur-sm px-3 py-1 rounded-full" style="background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.1)">
                                <i class="fas fa-circle text-green-400 text-[5px] mr-1.5 align-middle"></i>Tim aktif
                            </span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3 mb-5">
                        <div class="m-pill"><div class="n">50<span style="color:var(--teal)">+</span></div><div class="l" data-i18n="snapshot.metric1">Inisiatif digital</div></div>
                        <div class="m-pill"><div class="n">30<span style="color:var(--sky)">+</span></div><div class="l" data-i18n="snapshot.metric2">Klien berbagai sektor</div></div>
                        <div class="m-pill"><div class="n">5<span style="color:var(--violet)">+</span></div><div class="l" data-i18n="snapshot.metric3">Tahun pengalaman</div></div>
                        <div class="m-pill"><div class="n" style="font-size:1.5rem">24/7</div><div class="l" data-i18n="snapshot.metric4">Dukungan operasional</div></div>
                    </div>
                    <div class="rounded-2xl p-4" style="background:rgba(56,189,248,.06);border:1px solid rgba(56,189,248,.12)">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-bullseye text-sky-300 mt-0.5 flex-shrink-0"></i>
                            <p class="text-xs leading-relaxed text-slate-300" data-i18n="snapshot.desc">Fokus pada hasil bisnis — sistem stabil, workflow lebih cepat, fondasi teknologi siap scale-up.</p>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="flex">
                                <i class="fas fa-star text-amber-400 text-xs"></i><i class="fas fa-star text-amber-400 text-xs"></i><i class="fas fa-star text-amber-400 text-xs"></i><i class="fas fa-star text-amber-400 text-xs"></i><i class="fas fa-star text-amber-400 text-xs"></i>
                            </div>
                            <span class="text-xs text-slate-400">4.9 client rating</span>
                        </div>
                        <span class="text-xs text-slate-500 px-3 py-1 rounded-full" style="background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.06)">98% visibility</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 opacity-30 pointer-events-none">
        <span class="text-xs text-slate-400 tracking-widest uppercase">Scroll</span>
        <div class="w-px h-10 bg-gradient-to-b from-slate-400 to-transparent"></div>
    </div>
</section>

<!-- ══════════════════════════════════ VALUES STRIP ══ -->
<section class="py-8">
    <div class="max-w-7xl mx-auto px-5 sm:px-8">
        <div class="glass rounded-[1.75rem] p-6 sm:p-8 reveal">
            <div class="grid gap-6 md:grid-cols-3 items-start">
                <div>
                    <p class="badge-lbl" data-i18n="values.badge">Nilai Utama</p>
                    <h2 class="text-xl font-bold text-white leading-snug" data-i18n="values.title">Partner teknologi yang tidak sekadar membangun, tapi membantu bisnis tumbuh.</h2>
                </div>
                <div class="glass rounded-2xl p-5 hov-card">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-3" style="background:rgba(45,212,191,.1)"><i class="fas fa-shield-halved text-teal-300"></i></div>
                    <h3 class="font-bold text-white mb-1" data-i18n="values.card1Title">Security & Reliability</h3>
                    <p class="text-sm text-slate-400 leading-relaxed" data-i18n="values.card1Desc">Arsitektur dan implementasi dibangun dengan standar keamanan dan kestabilan operasional.</p>
                </div>
                <div class="glass rounded-2xl p-5 hov-card">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-3" style="background:rgba(251,191,36,.1)"><i class="fas fa-bolt text-amber-300"></i></div>
                    <h3 class="font-bold text-white mb-1" data-i18n="values.card2Title">Execution with Clarity</h3>
                    <p class="text-sm text-slate-400 leading-relaxed" data-i18n="values.card2Desc">Roadmap, milestone, dan komunikasi project disusun jelas agar keputusan lebih cepat.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════ ABOUT ══ -->
<section id="about" class="py-20 sm:py-28">
    <div class="max-w-7xl mx-auto px-5 sm:px-8">
        <div class="grid gap-12 lg:grid-cols-2 items-center">
            <div class="glass2 rounded-[2rem] p-8 sm:p-10 reveal-l">
                <p class="badge-lbl" data-i18n="about.badge">Tentang Kami</p>
                <h2 class="text-3xl sm:text-4xl font-bold text-white leading-snug" data-i18n="about.title">PT Fluxa Tritama Indonesia hadir untuk memperkuat transformasi digital bisnis.</h2>
                <div class="mt-5 h-px w-20" style="background:linear-gradient(90deg,var(--teal),transparent)"></div>
                <p class="mt-5 text-sm leading-relaxed text-slate-300" data-i18n="about.desc1">Kami adalah perusahaan IT yang membantu organisasi merancang, membangun, dan mengelola solusi teknologi yang benar-benar dipakai untuk operasional dan pertumbuhan bisnis.</p>
                <p class="mt-3 text-sm leading-relaxed text-slate-300" data-i18n="about.desc2">Fokus kami ada pada kualitas delivery, kejelasan proses, dan solusi yang relevan dengan kebutuhan lapangan.</p>
                <div class="mt-7 flex gap-3">
                    <a href="#contact" class="btn-p py-2.5 px-5 text-sm" data-i18n="cta.consult">Konsultasi</a>
                    <a href="#services" class="btn-s py-2.5 px-5 text-sm" data-i18n="nav.services">Layanan</a>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 reveal-r">
                @php
                $aCards=[
                    ['bg'=>'rgba(56,189,248,.1)','ic'=>'fas fa-laptop-code','tc'=>'text-sky-300','ti'=>'about.card1Title','tt'=>'Business-Driven Build','di'=>'about.card1Desc','dt'=>'Setiap solusi menjawab kebutuhan proses dan target bisnis yang konkret.'],
                    ['bg'=>'rgba(45,212,191,.1)','ic'=>'fas fa-diagram-project','tc'=>'text-teal-300','ti'=>'about.card2Title','tt'=>'Structured Delivery','di'=>'about.card2Desc','dt'=>'Workflow terukur, transparan, mudah dikontrol.'],
                    ['bg'=>'rgba(251,191,36,.1)','ic'=>'fas fa-server','tc'=>'text-amber-300','ti'=>'about.card3Title','tt'=>'Scalable Foundation','di'=>'about.card3Desc','dt'=>'Sistem dirancang siap berkembang mengikuti bisnis.'],
                    ['bg'=>'rgba(251,113,133,.1)','ic'=>'fas fa-headset','tc'=>'text-rose-300','ti'=>'about.card4Title','tt'=>'Long-Term Support','di'=>'about.card4Desc','dt'=>'Dukungan pasca go-live agar sistem tetap sehat.'],
                ];
                @endphp
                @foreach($aCards as $c)
                <div class="svc">
                    <div class="svc-ic" style="background:{{ $c['bg'] }}"><i class="{{ $c['ic'] }} {{ $c['tc'] }}"></i></div>
                    <h3 class="font-bold text-white text-base mb-2" data-i18n="{{ $c['ti'] }}">{{ $c['tt'] }}</h3>
                    <p class="text-xs text-slate-400 leading-relaxed" data-i18n="{{ $c['di'] }}">{{ $c['dt'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════ VISION & MISSION ══ -->
<section id="vision" class="py-20 sm:py-28">
    <div class="max-w-7xl mx-auto px-5 sm:px-8">
        <div class="text-center mb-14 reveal">
            <p class="badge-lbl justify-center" data-i18n="vision.badge">Visi & Misi</p>
            <h2 class="text-3xl sm:text-5xl font-bold text-white max-w-3xl mx-auto leading-snug" data-i18n="vision.title">Arah strategis dalam membangun solusi digital yang relevan dan bernilai.</h2>
        </div>
        <div class="grid gap-6 lg:grid-cols-[1fr_1.4fr]">
            <div class="glass2 rounded-[2rem] p-8 reveal-l flex flex-col gap-6">
                <div>
                    <p class="badge-lbl" data-i18n="vision.visionLabel">Visi</p>
                    <p class="text-sm leading-relaxed text-slate-300" data-i18n="vision.visionText">Menjadi perusahaan teknologi terpercaya yang menghadirkan solusi digital inovatif, adaptif, dan bernilai untuk mendukung pertumbuhan bisnis di era digital.</p>
                </div>
                <div class="p-5 rounded-2xl" style="background:linear-gradient(135deg,rgba(45,212,191,.08),rgba(56,189,248,.06));border:1px solid rgba(45,212,191,.15)">
                    <div class="flex items-center gap-3 mb-3"><i class="fas fa-eye text-teal-300"></i><span class="text-sm font-semibold text-white">Focus Areas</span></div>
                    <div class="flex flex-wrap gap-2">
                        <span class="chip">Innovation</span><span class="chip">Reliability</span><span class="chip">Scalability</span><span class="chip">Value</span>
                    </div>
                </div>
            </div>
            <div class="space-y-3 reveal-r">
                @php
                $missions=[
                    ['bg'=>'rgba(45,212,191,.1)','tc'=>'#2dd4bf','ic'=>'fa-code','ti'=>'vision.mission1Title','tt'=>'Mengembangkan solusi digital yang tepat guna','di'=>'vision.mission1Desc','dt'=>'Membangun website, aplikasi, sistem informasi, dan layanan teknologi sesuai kebutuhan bisnis.'],
                    ['bg'=>'rgba(56,189,248,.1)','tc'=>'#38bdf8','ic'=>'fa-handshake','ti'=>'vision.mission2Title','tt'=>'Memberikan layanan profesional & berkelanjutan','di'=>'vision.mission2Desc','dt'=>'Menjaga kualitas pekerjaan, komunikasi, dan dukungan teknis agar solusi berjalan optimal.'],
                    ['bg'=>'rgba(167,139,250,.1)','tc'=>'#a78bfa','ic'=>'fa-rocket','ti'=>'vision.mission3Title','tt'=>'Mendorong transformasi digital bisnis','di'=>'vision.mission3Desc','dt'=>'Membantu pelaku usaha meningkatkan efisiensi melalui teknologi.'],
                    ['bg'=>'rgba(251,191,36,.1)','tc'=>'#fbbf24','ic'=>'fa-lightbulb','ti'=>'vision.mission4Title','tt'=>'Mengutamakan inovasi dan keandalan','di'=>'vision.mission4Desc','dt'=>'Menghadirkan sistem modern, aman, mudah digunakan, dan dapat dikembangkan.'],
                    ['bg'=>'rgba(251,113,133,.1)','tc'=>'#fb7185','ic'=>'fa-gem','ti'=>'vision.mission5Title','tt'=>'Membangun nilai melalui setiap solusi','di'=>'vision.mission5Desc','dt'=>'Menjadikan setiap ide dan teknologi sebagai karya yang memberi manfaat nyata.'],
                ];
                @endphp
                @foreach($missions as $i=>$m)
                <div class="svc flex items-start gap-4 d{{ $i+1 }}">
                    <div class="w-10 h-10 rounded-xl flex-shrink-0 flex items-center justify-center mt-0.5" style="background:{{ $m['bg'] }}">
                        <i class="fas {{ $m['ic'] }} text-sm" style="color:{{ $m['tc'] }}"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-white text-sm mb-1" data-i18n="{{ $m['ti'] }}">{{ $m['tt'] }}</h3>
                        <p class="text-xs text-slate-400 leading-relaxed" data-i18n="{{ $m['di'] }}">{{ $m['dt'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════ SERVICES ══ -->
<section id="services" class="py-20 sm:py-28">
    <div class="max-w-7xl mx-auto px-5 sm:px-8">
        <div class="max-w-3xl mb-14 reveal">
            <p class="badge-lbl" data-i18n="services.badge">Layanan</p>
            <h2 class="text-3xl sm:text-5xl font-bold text-white leading-snug" data-i18n="services.title">Solusi IT dirancang untuk operasional dan pertumbuhan bisnis.</h2>
            <p class="mt-4 text-sm leading-relaxed text-slate-400" data-i18n="services.desc">Kami menggabungkan pengembangan software, infrastruktur, dan konsultasi implementasi.</p>
        </div>
        <div class="grid gap-6 lg:grid-cols-3">
            @php
            $svcs=[
                ['bg'=>'rgba(45,212,191,.1)','ic'=>'fas fa-code','tc'=>'text-teal-300','label'=>'Application Development','ti'=>'services.card1Title','tt'=>'Application Development','di'=>'services.card1Desc','dt'=>'Pengembangan aplikasi web, mobile, dan sistem internal untuk digitalisasi proses bisnis dan layanan pelanggan.','chips'=>['Company Website','Internal System','Mobile App']],
                ['bg'=>'rgba(56,189,248,.1)','ic'=>'fas fa-network-wired','tc'=>'text-sky-300','label'=>'Infrastructure','ti'=>'services.card2Title','tt'=>'Infrastructure & Network','di'=>'services.card2Desc','dt'=>'Perencanaan dan implementasi infrastruktur IT, jaringan, serta lingkungan operasional yang aman dan stabil.','chips'=>['LAN / WAN','Server Setup','Security Hardening']],
                ['bg'=>'rgba(251,191,36,.1)','ic'=>'fas fa-boxes-stacked','tc'=>'text-amber-300','label'=>'Procurement','ti'=>'services.card3Title','tt'=>'IT Procurement','di'=>'services.card3Desc','dt'=>'Pengadaan perangkat keras, perangkat lunak, dan kebutuhan teknis dengan pendekatan efisien dan tepat guna.','chips'=>['Hardware','Software','Deployment Support']],
            ];
            @endphp
            @foreach($svcs as $i=>$s)
            <article class="svc reveal d{{ $i+1 }}">
                <div class="svc-ic" style="background:{{ $s['bg'] }}"><i class="{{ $s['ic'] }} {{ $s['tc'] }}"></i></div>
                <span class="chip text-xs mb-3 inline-block">{{ $s['label'] }}</span>
                <h3 class="text-2xl font-bold text-white mb-3" data-i18n="{{ $s['ti'] }}">{{ $s['tt'] }}</h3>
                <p class="text-sm leading-relaxed text-slate-400 mb-5" data-i18n="{{ $s['di'] }}">{{ $s['dt'] }}</p>
                <div class="gl mb-4"></div>
                <div class="flex flex-wrap gap-2">
                    @foreach($s['chips'] as $ch)<span class="chip">{{ $ch }}</span>@endforeach
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

<!-- ══════════════════════════════════ INSIGHTS ══ -->
<section id="insights" class="py-20 sm:py-28">
    <div class="max-w-7xl mx-auto px-5 sm:px-8">
        <div class="grid gap-10 lg:grid-cols-[1fr_1.3fr] items-start">
            <div class="reveal-l">
                <p class="badge-lbl" data-i18n="insight.badge">Performance Insight</p>
                <h2 class="text-3xl sm:text-4xl font-bold text-white leading-snug mb-4" data-i18n="insight.title">Data-driven delivery untuk hasil yang lebih terukur.</h2>
                <p class="text-sm leading-relaxed text-slate-400 mb-8" data-i18n="insight.desc">Grafik ini menunjukkan pertumbuhan delivery, efektivitas implementasi, dan fokus prioritas layanan.</p>
                <div class="grid grid-cols-3 gap-4">
                    <div class="glass rounded-2xl p-4 text-center hov-card"><div class="text-2xl font-extrabold text-white">+42%</div><div class="text-xs text-slate-400 mt-1" data-i18n="insight.stat1">Efisiensi workflow</div></div>
                    <div class="glass rounded-2xl p-4 text-center hov-card"><div class="text-2xl font-extrabold text-white">12x</div><div class="text-xs text-slate-400 mt-1" data-i18n="insight.stat2">Faster reporting</div></div>
                    <div class="glass rounded-2xl p-4 text-center hov-card"><div class="text-2xl font-extrabold text-white">99.2%</div><div class="text-xs text-slate-400 mt-1" data-i18n="insight.stat3">Stability target</div></div>
                </div>
            </div>
            <div class="glass2 rounded-[2rem] p-6 sm:p-8 reveal-r overflow-hidden">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
                    <div><p class="badge-lbl" data-i18n="insight.chartBadge">Delivery Growth</p><h3 class="text-xl font-bold text-white" data-i18n="insight.chartTitle">Service Mix & Impact</h3></div>
                    <span class="chip text-xs" data-i18n="insight.chartNote">Demo chart</span>
                </div>
                <div class="chart-wrap" style="position:relative;width:100%;height:260px"><canvas id="svcChart" style="max-width:100%"></canvas></div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════ INDUSTRIES ══ -->
<section id="industries" class="py-20 sm:py-28">
    <div class="max-w-7xl mx-auto px-5 sm:px-8">
        <div class="glass rounded-[2rem] p-8 sm:p-10 reveal">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-10">
                <div class="max-w-2xl">
                    <p class="badge-lbl" data-i18n="industries.badge">Sektor yang Dilayani</p>
                    <h2 class="text-3xl sm:text-4xl font-bold text-white leading-snug" data-i18n="industries.title">Relevan untuk berbagai jenis organisasi.</h2>
                </div>
                <p class="max-w-sm text-sm leading-relaxed text-slate-400" data-i18n="industries.desc">Pendekatan fleksibel — dari startup hingga enterprise.</p>
            </div>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @php
                $inds=[
                    ['bg'=>'rgba(56,189,248,.1)','tc'=>'#38bdf8','ic'=>'fa-building','ti'=>'industries.card1Title','tt'=>'Corporate & SME','di'=>'industries.card1Desc','dt'=>'Digitalisasi workflow, dashboard operasional, dan sistem pendukung keputusan.'],
                    ['bg'=>'rgba(45,212,191,.1)','tc'=>'#2dd4bf','ic'=>'fa-store','ti'=>'industries.card2Title','tt'=>'Retail & Distribution','di'=>'industries.card2Desc','dt'=>'Integrasi penjualan, inventory, reporting, dan monitoring cabang.'],
                    ['bg'=>'rgba(167,139,250,.1)','tc'=>'#a78bfa','ic'=>'fa-graduation-cap','ti'=>'industries.card3Title','tt'=>'Education & Public','di'=>'industries.card3Desc','dt'=>'Sistem informasi, portal layanan, dan tata kelola data yang tertata.'],
                    ['bg'=>'rgba(251,191,36,.1)','tc'=>'#fbbf24','ic'=>'fa-industry','ti'=>'industries.card4Title','tt'=>'Industrial Operations','di'=>'industries.card4Desc','dt'=>'Jaringan, monitoring, dan solusi penunjang operasional lapangan.'],
                ];
                @endphp
                @foreach($inds as $ind)
                <div class="ind">
                    <div class="ind-ic" style="background:{{ $ind['bg'] }}"><i class="fas {{ $ind['ic'] }}" style="color:{{ $ind['tc'] }}"></i></div>
                    <h3 class="font-bold text-white mb-2" data-i18n="{{ $ind['ti'] }}">{{ $ind['tt'] }}</h3>
                    <p class="text-xs text-slate-400 leading-relaxed" data-i18n="{{ $ind['di'] }}">{{ $ind['dt'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════ PORTFOLIO ══ -->
<section id="portfolio" class="py-20 sm:py-28">
    <div class="max-w-7xl mx-auto px-5 sm:px-8">
        <div class="max-w-3xl mb-14 reveal">
            <p class="badge-lbl" data-i18n="portfolio.badge">Kapabilitas</p>
            <h2 class="text-3xl sm:text-5xl font-bold text-white leading-snug" data-i18n="portfolio.title">Area solusi yang bisa kami kerjakan untuk bisnis Anda.</h2>
        </div>
        <div class="grid gap-6 lg:grid-cols-3">
            @php
            $ports=[
                ['bg'=>'rgba(56,189,248,.1)','ic'=>'fas fa-chart-line','tc'=>'text-sky-300','label'=>'Dashboard','ti'=>'portfolio.card1Title','tt'=>'Executive Dashboard','di'=>'portfolio.card1Desc','dt'=>'Dashboard ringkas untuk memantau KPI, operasional, penjualan, dan data penting lintas unit bisnis.'],
                ['bg'=>'rgba(45,212,191,.1)','ic'=>'fas fa-mobile-screen-button','tc'=>'text-teal-300','label'=>'Mobile & Web','ti'=>'portfolio.card2Title','tt'=>'Customer-Facing Apps','di'=>'portfolio.card2Desc','dt'=>'Aplikasi dan portal yang meningkatkan layanan pelanggan dan pengalaman digital.'],
                ['bg'=>'rgba(251,191,36,.1)','ic'=>'fas fa-server','tc'=>'text-amber-300','label'=>'Infrastructure','ti'=>'portfolio.card3Title','tt'=>'Infrastructure Modernization','di'=>'portfolio.card3Desc','dt'=>'Pembaruan jaringan, server, dan lingkungan IT agar aman dan siap berkembang.'],
            ];
            @endphp
            @foreach($ports as $i=>$p)
            <article class="svc reveal d{{ $i+1 }} group">
                <div class="flex items-center justify-between mb-5">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center" style="background:{{ $p['bg'] }}">
                        <i class="{{ $p['ic'] }} {{ $p['tc'] }} text-xl transition-transform group-hover:scale-110"></i>
                    </div>
                    <span class="chip text-xs">{{ $p['label'] }}</span>
                </div>
                <h3 class="text-2xl font-bold text-white mb-3" data-i18n="{{ $p['ti'] }}">{{ $p['tt'] }}</h3>
                <p class="text-sm leading-relaxed text-slate-400" data-i18n="{{ $p['di'] }}">{{ $p['dt'] }}</p>
            </article>
            @endforeach
        </div>
    </div>
</section>

<!-- ══════════════════════════════════ PROCESS ══ -->
<section id="process" class="py-20 sm:py-28">
    <div class="max-w-7xl mx-auto px-5 sm:px-8">
        <div class="grid gap-12 lg:grid-cols-[1fr_1.3fr] items-start">
            <div class="reveal-l lg:sticky lg:top-24">
                <p class="badge-lbl" data-i18n="process.badge">Proses Kerja</p>
                <h2 class="text-3xl sm:text-4xl font-bold text-white leading-snug mb-4" data-i18n="process.title">Cara kami memastikan project tetap jelas, terarah, dan deliverable.</h2>
                <p class="text-sm leading-relaxed text-slate-400" data-i18n="process.desc">Struktur kerja yang rapi mengurangi risiko miskomunikasi dan menjaga kualitas implementasi.</p>
                <div class="mt-8 glass rounded-2xl p-5">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-2 h-2 rounded-full bg-teal-400 pr"></div>
                        <span class="text-xs font-semibold text-slate-300">Project in progress</span>
                    </div>
                    <div class="space-y-2">
                        @foreach([['w-full','bg-teal-400'],['w-4/5','bg-sky-400'],['w-3/5','bg-violet-400'],['w-2/5','bg-amber-400']] as $b)
                        <div class="h-1.5 rounded-full overflow-hidden" style="background:rgba(255,255,255,.05)">
                            <div class="{{ $b[0] }} {{ $b[1] }} h-full rounded-full opacity-70"></div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="reveal-r">
                <div class="space-y-4">
                    @php
                    $steps=[
                        ['n'=>'01','c'=>'#2dd4bf','ti'=>'process.step1Title','tt'=>'Discovery & Requirement Mapping','di'=>'process.step1Desc','dt'=>'Kami memetakan kebutuhan bisnis, proses berjalan, dan target implementasi sebelum eksekusi.'],
                        ['n'=>'02','c'=>'#38bdf8','ti'=>'process.step2Title','tt'=>'Solution Design','di'=>'process.step2Desc','dt'=>'Arsitektur solusi, alur kerja, dan prioritas implementasi selaras dengan kebutuhan bisnis.'],
                        ['n'=>'03','c'=>'#a78bfa','ti'=>'process.step3Title','tt'=>'Build & Implementation','di'=>'process.step3Desc','dt'=>'Tim menjalankan pengembangan, setup, dan konfigurasi dengan pendekatan terukur.'],
                        ['n'=>'04','c'=>'#fbbf24','ti'=>'process.step4Title','tt'=>'Testing, Handover & Support','di'=>'process.step4Desc','dt'=>'Solusi divalidasi, diserahterimakan, lalu didukung agar stabil di lapangan.'],
                    ];
                    @endphp
                    @foreach($steps as $i=>$s)
                    <div class="step d{{ $i+1 }}">
                        @if(!$loop->last)<div class="step-ln"></div>@endif
                        <div class="step-n" style="background:{{ $s['c'] }}">{{ $s['n'] }}</div>
                        <h3 class="font-bold text-white mb-1" data-i18n="{{ $s['ti'] }}">{{ $s['tt'] }}</h3>
                        <p class="text-sm text-slate-400 leading-relaxed" data-i18n="{{ $s['di'] }}">{{ $s['dt'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════ CLIENTS ══ -->
<section id="partners" class="py-20 sm:py-28">
    <div class="max-w-7xl mx-auto px-5 sm:px-8">
        <div class="glass rounded-[2rem] p-8 sm:p-10 reveal">
            <p class="badge-lbl mb-6" data-i18n="clients.title">Klien Kami</p>
            <div class="mq-wrap">
                <div class="mq-track">
                    @php
                    $logos=[
                        ['assets/images/Clients/anugerah sarana hikmah.png','PT. Anugerah Sarana Hikmah'],
                        ['assets/images/Clients/Samudra-Mulia-Abadi2.jpg','PT. Samudra Mulia Abadi'],
                        ['assets/images/Clients/Logo-Adaro-Andalan-Indonesia-Color.png','Adaro Andalan Indonesia'],
                        ['assets/images/Clients/medali-mart.png','Medali Mart'],
                        ['assets/images/Clients/hasnurriung sinergi.png','Hasnur Riung Sinergi'],
                        ['assets/images/Clients/kalingga_logo.png','Kalingga'],
                        ['assets/images/Clients/Logo_Badan_Gizi_Nasional_(2024).png','Badan Gizi Nasional'],
                        ['assets/images/Clients/akartelangmandiri.ico','Akar Elang Mandiri'],
                    ];
                    $all = array_merge($logos,$logos);
                    @endphp
                    @foreach($all as $l)
                    <img src="{{ asset($l[0]) }}" alt="{{ $l[1] }}" class="mq-logo" loading="lazy">
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════ CONTACT ══ -->
<section id="contact" class="py-20 sm:py-28">
    <div class="max-w-7xl mx-auto px-5 sm:px-8">
        <div class="glass2 rounded-[1.5rem] sm:rounded-[2rem] p-5 sm:p-8 lg:p-14 relative overflow-hidden reveal">
            <div class="absolute top-0 right-0 w-80 h-80 rounded-full opacity-[.05] blur-3xl -translate-y-1/2 translate-x-1/2" style="background:radial-gradient(circle,#2dd4bf,#38bdf8)"></div>
            <div class="grid gap-8 lg:grid-cols-2 items-start relative z-10">
                <div>
                    <p class="badge-lbl" data-i18n="contact.badge">Kontak</p>
                    <h2 class="text-2xl sm:text-3xl lg:text-5xl font-bold text-white leading-snug mb-4" data-i18n="contact.title">Siap membangun sistem digital yang profesional?</h2>
                    <p class="text-sm leading-relaxed text-slate-400 mb-6" data-i18n="contact.desc">Jika Anda butuh website company profile, aplikasi internal, atau infrastruktur IT yang lebih rapi, kami siap membantu dari perencanaan sampai implementasi.</p>
                    <div class="flex flex-col gap-3">
                        <a href="https://wa.me/6281250653005" class="btn-p text-center py-3.5 px-7" data-i18n="contact.cta1"><i class="fab fa-whatsapp mr-2"></i>Chat via WhatsApp</a>
                        <a href="mailto:official@fluxa.co.id" class="btn-s text-center py-3.5 px-7" data-i18n="contact.cta2"><i class="fas fa-envelope mr-2"></i>Kirim Email</a>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="ct-item">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(56,189,248,.1)"><i class="fas fa-envelope text-sky-300 text-sm"></i></div>
                        <div class="min-w-0">
                            <p class="text-xs text-slate-500 uppercase tracking-widest mb-1" data-i18n="contact.card1">Email</p>
                            <a href="mailto:official@fluxa.co.id" class="text-sm text-slate-200 hover:text-white transition-colors break-all">official@fluxa.co.id</a>
                        </div>
                    </div>
                    <div class="ct-item">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(45,212,191,.1)"><i class="fas fa-phone text-teal-300 text-sm"></i></div>
                        <div class="min-w-0">
                            <p class="text-xs text-slate-500 uppercase tracking-widest mb-1" data-i18n="contact.card2">Telepon / WhatsApp</p>
                            <a href="tel:+6281250653005" class="text-sm text-slate-200 hover:text-white transition-colors">+62 812-5065-3005</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════ FOOTER ══ -->
<footer class="py-10" style="border-top:1px solid var(--border)">
    <div class="max-w-7xl mx-auto px-5 sm:px-8">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <img src="{{ asset('assets/images/logo-white-transparent.png') }}" alt="Fluxa" class="h-8 w-auto object-contain flex-shrink-0 logo-d">
            <img src="{{ asset('assets/images/logo-black-transparent.png') }}" alt="Fluxa" class="h-8 w-auto object-contain flex-shrink-0 logo-l" style="display:none">
            <p class="text-xs text-slate-500 max-w-sm" data-i18n="footer.taglinePrefix">PT Fluxa Tritama Indonesia menghadirkan layanan teknologi dan solusi digital untuk bisnis modern.</p>
            <p class="text-xs text-slate-600">&copy; <span id="yr"></span> PT Fluxa Tritama Indonesia. <span data-i18n="footer.copySuffix">All rights reserved.</span></p>
        </div>
    </div>
</footer>

</div><!-- /z-10 -->

<!-- ══════════════════════════════════ CHATBOT ══ -->
<button id="cb-fab" class="cb-fab" aria-label="Buka chatbot"><i class="fas fa-comments"></i></button>
<div id="cb-panel" class="cb-panel">
    <div class="cb-hdr">
        <div class="flex items-center justify-between">
            <div><p class="text-xs uppercase tracking-widest mb-0.5" style="color:rgba(56,189,248,.6)" data-i18n="chatbot.badge">Chatbot Demo</p><h3 class="font-bold text-white text-sm" data-i18n="chatbot.title">Fluxa Assistant</h3></div>
            <button id="cb-close" class="w-8 h-8 rounded-full flex items-center justify-center text-slate-400 hover:text-white hover:bg-white/10 transition-colors"><i class="fas fa-xmark text-sm"></i></button>
        </div>
    </div>
    <div id="cb-msgs" class="cb-msgs">
        <div class="cb-bbl bb-bot" data-i18n="chatbot.welcome">Halo! Saya siap membantu menjelaskan layanan PT Fluxa. Tanya soal website, aplikasi, atau konsultasi awal.</div>
    </div>
    <div class="cb-quick">
        <button class="cb-qbtn" data-prompt="layanan" data-i18n="chatbot.quick1">Layanan apa saja?</button>
        <button class="cb-qbtn" data-prompt="website" data-i18n="chatbot.quick2">Bisa buat website?</button>
        <button class="cb-qbtn" data-prompt="konsultasi" data-i18n="chatbot.quick3">Cara konsultasi?</button>
    </div>
    <div style="display:flex;gap:.375rem;padding:.375rem 1rem;border-top:1px solid var(--border)">
        <a href="https://wa.me/6281250653005" target="_blank" style="flex:1;display:flex;align-items:center;justify-content:center;gap:.3rem;padding:.375rem;border-radius:50px;background:linear-gradient(135deg,#25d366,#128c7e);color:#fff;font-size:.65rem;font-weight:700;text-decoration:none">
            <i class="fab fa-whatsapp"></i> WhatsApp
        </a>
        <a href="mailto:official@fluxa.co.id" style="flex:1;display:flex;align-items:center;justify-content:center;gap:.3rem;padding:.375rem;border-radius:50px;border:1px solid var(--border2);background:var(--surface);color:var(--text2);font-size:.65rem;font-weight:600;text-decoration:none">
            <i class="fas fa-envelope"></i> Email
        </a>
    </div>
    <form id="cb-form" class="cb-form">
        <input id="cb-inp" type="text" class="cb-inp" placeholder="Tulis pertanyaan…">
        <button type="submit" class="cb-send"><i class="fas fa-paper-plane"></i></button>
    </form>
</div>

<button id="btt" aria-label="Kembali ke atas"><i class="fas fa-chevron-up text-sm"></i></button>

<!-- ══════════════════════════════════ SCRIPT ══ -->
<script>
/* ── i18n ─────────────────────────────────────────────────── */
const T={
  id:{'nav.about':'Tentang','nav.services':'Layanan','nav.industries':'Industri','nav.projects':'Proyek','nav.process':'Proses','nav.contact':'Kontak','cta.email':'Email Kami','cta.consult':'Konsultasi','hero.badge':'Every Flow Builds The Future','hero.title1':'Solusi IT Profesional untuk Bisnis yang Ingin','hero.title2':'Tumbuh Lebih Cepat.','hero.desc':'PT Fluxa Tritama Indonesia membantu perusahaan membangun sistem digital, aplikasi bisnis, dan infrastruktur IT yang aman, efisien, serta siap dikembangkan.','hero.ctaPrimary':'Diskusikan Kebutuhan','hero.ctaSecondary':'Lihat Layanan','snapshot.badge':'Company Snapshot','snapshot.titleLine1':'Why PT Fluxa Tritama Indonesia','snapshot.titleLine2':'Tritama Indonesia','snapshot.metric1':'Inisiatif Digital','snapshot.metric2':'Klien Aktif','snapshot.metric3':'Tahun Pengalaman','snapshot.metric4':'Dukungan Operasional','snapshot.desc':'Fokus pada hasil bisnis — sistem stabil, workflow lebih cepat, fondasi teknologi siap scale-up.','values.badge':'Nilai Utama','values.title':'Partner teknologi yang tidak sekadar membangun, tapi membantu bisnis tumbuh.','values.card1Title':'Security & Reliability','values.card1Desc':'Arsitektur dan implementasi dibangun dengan standar keamanan dan kestabilan operasional.','values.card2Title':'Execution with Clarity','values.card2Desc':'Roadmap, milestone, dan komunikasi project disusun jelas agar keputusan lebih cepat.','about.badge':'Tentang Kami','about.title':'PT Fluxa Tritama Indonesia hadir untuk memperkuat transformasi digital bisnis.','about.desc1':'Kami adalah perusahaan IT yang membantu organisasi merancang, membangun, dan mengelola solusi teknologi yang benar-benar dipakai untuk operasional dan pertumbuhan bisnis.','about.desc2':'Fokus kami ada pada kualitas delivery, kejelasan proses, dan solusi yang relevan dengan kebutuhan lapangan.','about.card1Title':'Business-Driven Build','about.card1Desc':'Setiap solusi menjawab kebutuhan proses dan target bisnis yang konkret.','about.card2Title':'Structured Delivery','about.card2Desc':'Workflow terukur, transparan, mudah dikontrol.','about.card3Title':'Scalable Foundation','about.card3Desc':'Sistem dirancang siap berkembang mengikuti bisnis.','about.card4Title':'Long-Term Support','about.card4Desc':'Dukungan pasca go-live agar sistem tetap sehat.','vision.badge':'Visi & Misi','vision.title':'Arah strategis dalam membangun solusi digital yang relevan dan bernilai.','vision.visionLabel':'Visi','vision.visionText':'Menjadi perusahaan teknologi terpercaya yang menghadirkan solusi digital inovatif, adaptif, dan bernilai untuk mendukung pertumbuhan bisnis di era digital.','vision.mission1Title':'Mengembangkan solusi digital yang tepat guna','vision.mission1Desc':'Membangun website, aplikasi, sistem informasi, dan layanan teknologi sesuai kebutuhan bisnis.','vision.mission2Title':'Memberikan layanan profesional & berkelanjutan','vision.mission2Desc':'Menjaga kualitas pekerjaan, komunikasi, dan dukungan teknis agar solusi berjalan optimal.','vision.mission3Title':'Mendorong transformasi digital bisnis','vision.mission3Desc':'Membantu pelaku usaha meningkatkan efisiensi melalui teknologi.','vision.mission4Title':'Mengutamakan inovasi dan keandalan','vision.mission4Desc':'Menghadirkan sistem modern, aman, mudah digunakan, dan dapat dikembangkan.','vision.mission5Title':'Membangun nilai melalui setiap solusi','vision.mission5Desc':'Menjadikan setiap ide dan teknologi sebagai karya yang memberi manfaat nyata.','services.badge':'Layanan','services.title':'Solusi IT dirancang untuk operasional dan pertumbuhan bisnis.','services.desc':'Kami menggabungkan pengembangan software, infrastruktur, dan konsultasi implementasi.','services.card1Title':'Application Development','services.card1Desc':'Pengembangan aplikasi web, mobile, dan sistem internal untuk digitalisasi proses bisnis.','services.card2Title':'Infrastructure & Network','services.card2Desc':'Perencanaan dan implementasi infrastruktur IT, jaringan, serta lingkungan operasional yang aman.','services.card3Title':'IT Procurement','services.card3Desc':'Pengadaan perangkat keras, perangkat lunak, dan kebutuhan teknis dengan pendekatan efisien.','insight.badge':'Performance Insight','insight.title':'Data-driven delivery untuk hasil yang lebih terukur.','insight.desc':'Grafik ini menunjukkan pertumbuhan delivery, efektivitas implementasi, dan prioritas layanan.','insight.stat1':'Efisiensi workflow','insight.stat2':'Faster reporting','insight.stat3':'Stability target','insight.chartBadge':'Delivery Growth','insight.chartTitle':'Service Mix & Impact','insight.chartNote':'Demo chart','industries.badge':'Sektor yang Dilayani','industries.title':'Relevan untuk berbagai jenis organisasi.','industries.desc':'Pendekatan fleksibel — dari startup hingga enterprise.','industries.card1Title':'Corporate & SME','industries.card1Desc':'Digitalisasi workflow, dashboard operasional, dan sistem pendukung keputusan.','industries.card2Title':'Retail & Distribution','industries.card2Desc':'Integrasi penjualan, inventory, reporting, dan monitoring cabang.','industries.card3Title':'Education & Public','industries.card3Desc':'Sistem informasi, portal layanan, dan tata kelola data yang tertata.','industries.card4Title':'Industrial Operations','industries.card4Desc':'Jaringan, monitoring, dan solusi penunjang operasional lapangan.','portfolio.badge':'Kapabilitas','portfolio.title':'Area solusi yang bisa kami kerjakan untuk bisnis Anda.','portfolio.card1Title':'Executive Dashboard','portfolio.card1Desc':'Dashboard ringkas untuk memantau KPI, operasional, dan penjualan lintas unit bisnis.','portfolio.card2Title':'Customer-Facing Apps','portfolio.card2Desc':'Aplikasi dan portal yang meningkatkan layanan pelanggan dan pengalaman digital.','portfolio.card3Title':'Infrastructure Modernization','portfolio.card3Desc':'Pembaruan jaringan, server, dan lingkungan IT agar aman dan siap berkembang.','process.badge':'Proses Kerja','process.title':'Cara kami memastikan project tetap jelas, terarah, dan deliverable.','process.desc':'Struktur kerja yang rapi mengurangi risiko miskomunikasi dan menjaga kualitas implementasi.','process.step1Title':'Discovery & Requirement Mapping','process.step1Desc':'Kami memetakan kebutuhan bisnis, proses berjalan, dan target implementasi sebelum eksekusi.','process.step2Title':'Solution Design','process.step2Desc':'Arsitektur solusi, alur kerja, dan prioritas implementasi selaras dengan kebutuhan bisnis.','process.step3Title':'Build & Implementation','process.step3Desc':'Tim menjalankan pengembangan, setup, dan konfigurasi dengan pendekatan terukur.','process.step4Title':'Testing, Handover & Support','process.step4Desc':'Solusi divalidasi, diserahterimakan, lalu didukung agar stabil di lapangan.','clients.title':'Klien Kami','contact.badge':'Kontak','contact.title':'Siap membangun sistem digital yang profesional?','contact.desc':'Jika Anda butuh website company profile, aplikasi internal, atau infrastruktur IT yang lebih rapi, kami siap membantu.','contact.cta1':'Chat via WhatsApp','contact.cta2':'Kirim Email','contact.card1':'Email','contact.card2':'Telepon / WhatsApp','contact.card3':'Lokasi','contact.location':'Kalimantan, Indonesia','footer.taglinePrefix':'PT Fluxa Tritama Indonesia menghadirkan layanan teknologi dan solusi digital untuk bisnis modern.','footer.copySuffix':'All rights reserved.','chatbot.badge':'Chatbot Demo','chatbot.title':'Fluxa Assistant','chatbot.welcome':'Halo! Saya siap membantu menjelaskan layanan PT Fluxa. Tanya soal website, aplikasi, atau konsultasi awal.','chatbot.quick1':'Layanan apa saja?','chatbot.quick2':'Bisa buat website?','chatbot.quick3':'Cara konsultasi?'},
  en:{'nav.about':'About','nav.services':'Services','nav.industries':'Industries','nav.projects':'Projects','nav.process':'Process','nav.contact':'Contact','cta.email':'Email Us','cta.consult':'Consult','hero.badge':'Every Flow Builds The Future','hero.title1':'Professional IT Solutions for Businesses That Want to','hero.title2':'Grow Faster.','hero.desc':'PT Fluxa Tritama Indonesia helps companies build digital systems, business applications, and IT infrastructure that are secure, efficient, and scalable.','hero.ctaPrimary':'Discuss Your Needs','hero.ctaSecondary':'See Services','snapshot.badge':'Company Snapshot','snapshot.titleLine1':'Why PT Fluxa Tritama Indonesia','snapshot.titleLine2':'Tritama Indonesia','snapshot.metric1':'Digital Initiatives','snapshot.metric2':'Active Clients','snapshot.metric3':'Years Experience','snapshot.metric4':'Operational Support','snapshot.desc':'Focus on business outcomes — stable systems, faster workflows, technology foundation ready to scale.','values.badge':'Core Values','values.title':'A technology partner that not only builds, but helps businesses grow.','values.card1Title':'Security & Reliability','values.card1Desc':'Architecture and implementation built to security and operational stability standards.','values.card2Title':'Execution with Clarity','values.card2Desc':'Roadmaps, milestones, and project communication structured for faster decisions.','about.badge':'About Us','about.title':'PT Fluxa Tritama Indonesia strengthens digital transformation for businesses.','about.desc1':'We are an IT company that helps organizations design, build, and manage technology solutions for operations and business growth.','about.desc2':'Our focus is on quality delivery, clear processes, and solutions relevant to real-world needs.','about.card1Title':'Business-Driven Build','about.card1Desc':'Every solution answers process needs and concrete business targets.','about.card2Title':'Structured Delivery','about.card2Desc':'Measurable, transparent, easy-to-control workflows.','about.card3Title':'Scalable Foundation','about.card3Desc':'Systems designed to grow with your business.','about.card4Title':'Long-Term Support','about.card4Desc':'Post-launch support to keep systems healthy.','vision.badge':'Vision & Mission','vision.title':'Strategic direction in building relevant and valuable digital solutions.','vision.visionLabel':'Vision','vision.visionText':'To become a trusted technology company delivering innovative, adaptive, and valuable digital solutions to support business growth in the digital era.','vision.mission1Title':'Develop purpose-built digital solutions','vision.mission1Desc':'Building websites, applications, information systems, and technology services suited to client needs.','vision.mission2Title':'Provide professional & sustainable service','vision.mission2Desc':'Maintaining work quality, communication, and technical support so solutions run optimally.','vision.mission3Title':'Drive digital business transformation','vision.mission3Desc':'Helping businesses improve efficiency through technology.','vision.mission4Title':'Prioritize innovation and reliability','vision.mission4Desc':'Delivering modern, secure, easy-to-use, and developable systems.','vision.mission5Title':'Build value through every solution','vision.mission5Desc':'Making every idea and technology a work that delivers real benefits.','services.badge':'Services','services.title':'IT solutions designed for operations and business growth.','services.desc':'We combine software development, infrastructure, and implementation consulting.','services.card1Title':'Application Development','services.card1Desc':'Web, mobile, and internal application development for digitizing business processes.','services.card2Title':'Infrastructure & Network','services.card2Desc':'Planning and implementing IT infrastructure, networking, and secure operational environments.','services.card3Title':'IT Procurement','services.card3Desc':'Hardware, software, and technical needs procurement with an efficient approach.','insight.badge':'Performance Insight','insight.title':'Data-driven delivery for more measurable results.','insight.desc':'This chart shows delivery growth, implementation effectiveness, and service priority focus.','insight.stat1':'Workflow efficiency','insight.stat2':'Faster reporting','insight.stat3':'Stability target','insight.chartBadge':'Delivery Growth','insight.chartTitle':'Service Mix & Impact','insight.chartNote':'Demo chart','industries.badge':'Industries Served','industries.title':'Relevant for various types of organizations.','industries.desc':'Flexible approach — from startups to enterprises.','industries.card1Title':'Corporate & SME','industries.card1Desc':'Workflow digitalization, operational dashboards, and decision support systems.','industries.card2Title':'Retail & Distribution','industries.card2Desc':'Sales integration, inventory, reporting, and branch monitoring.','industries.card3Title':'Education & Public','industries.card3Desc':'Information systems, service portals, and organized data governance.','industries.card4Title':'Industrial Operations','industries.card4Desc':'Networking, monitoring, and operational support solutions in the field.','portfolio.badge':'Capabilities','portfolio.title':'Solution areas we can deliver for your business.','portfolio.card1Title':'Executive Dashboard','portfolio.card1Desc':'Concise dashboard to monitor KPIs, operations, and sales across business units.','portfolio.card2Title':'Customer-Facing Apps','portfolio.card2Desc':'Apps and portals that improve customer service and digital experience.','portfolio.card3Title':'Infrastructure Modernization','portfolio.card3Desc':'Network, server, and IT environment upgrades for secure and scalable operations.','process.badge':'Work Process','process.title':'How we ensure projects stay clear, directed, and deliverable.','process.desc':'Neat work structure reduces miscommunication risks and maintains implementation quality.','process.step1Title':'Discovery & Requirement Mapping','process.step1Desc':'We map business needs, current processes, and implementation targets before execution.','process.step2Title':'Solution Design','process.step2Desc':'Solution architecture, workflows, and implementation priorities aligned with business needs.','process.step3Title':'Build & Implementation','process.step3Desc':'The team executes development, setup, and configuration with a measured approach.','process.step4Title':'Testing, Handover & Support','process.step4Desc':'Solution validated, handed over clearly, then supported to stay stable in the field.','clients.title':'Our Clients','contact.badge':'Contact','contact.title':'Ready to build a professional digital system?','contact.desc':'Need a company profile website, internal application, or tidier IT infrastructure? We help from planning to implementation.','contact.cta1':'Chat via WhatsApp','contact.cta2':'Send Email','contact.card1':'Email','contact.card2':'Phone / WhatsApp','contact.card3':'Location','contact.location':'Kalimantan, Indonesia','footer.taglinePrefix':'PT Fluxa Tritama Indonesia delivers technology services and digital solutions for modern businesses.','footer.copySuffix':'All rights reserved.','chatbot.badge':'Chatbot Demo','chatbot.title':'Fluxa Assistant','chatbot.welcome':'Hi! I\'m ready to explain PT Fluxa\'s services. Ask about websites, apps, infrastructure, or initial consultation.','chatbot.quick1':'What services?','chatbot.quick2':'Can you build a website?','chatbot.quick3':'How to consult?'},
  zh:{'nav.about':'关于','nav.services':'服务','nav.industries':'行业','nav.projects':'项目','nav.process':'流程','nav.contact':'联系','cta.email':'发送邮件','cta.consult':'咨询','hero.badge':'每一个流程，构建未来','hero.title1':'为希望实现快速增长的企业','hero.title2':'提供专业IT解决方案。','hero.desc':'PT Fluxa Tritama Indonesia帮助企业构建安全、高效且可扩展的数字系统、业务应用及IT基础设施。','hero.ctaPrimary':'讨论您的需求','hero.ctaSecondary':'查看服务','snapshot.badge':'公司简介','snapshot.titleLine1':'为何选择PT Fluxa','snapshot.titleLine2':'Tritama Indonesia','snapshot.metric1':'数字化项目与IT实施','snapshot.metric2':'多行业客户','snapshot.metric3':'项目交付经验年限','snapshot.metric4':'关键业务运营支持','snapshot.desc':'稳定的系统、更快的工作流程，以及随时准备扩展的技术基础。','values.badge':'核心价值','values.title':'不仅构建系统，更帮助企业快速前进的技术合作伙伴。','values.card1Title':'安全与可靠','values.card1Desc':'架构与实施均以安全标准和运营稳定性为基础。','values.card2Title':'清晰执行','values.card2Desc':'路线图、里程碑和项目沟通结构清晰，加快业务决策。','about.badge':'关于我们','about.title':'PT Fluxa Tritama Indonesia致力于加强印度尼西亚企业的数字化转型。','about.desc1':'我们是一家IT公司，帮助组织设计、构建和管理真正服务于运营和业务增长的技术解决方案。','about.desc2':'我们专注于交付质量、流程清晰度，以及贴近实际需求的解决方案——从内部应用到企业级基础设施。','about.card1Title':'业务驱动构建','about.card1Desc':'每个解决方案都围绕具体的业务流程、效率目标和运营需求设计。','about.card2Title':'结构化交付','about.card2Desc':'项目工作流可量化、透明且易于控制。','about.card3Title':'可扩展基础','about.card3Desc':'系统和基础设施按照未来业务增长需求进行设计。','about.card4Title':'长期支持','about.card4Desc':'我们不会在上线后停止，持续支持让系统保持健康与适用。','vision.badge':'愿景与使命','vision.title':'PT Fluxa Tritama Indonesia打造相关且有价值数字解决方案的战略方向。','vision.visionLabel':'愿景','vision.visionText':'成为一家值得信赖的科技公司，提供创新、适应性强且有价值的数字解决方案，支持企业在数字时代的增长。','vision.mission1Title':'开发实用的数字解决方案','vision.mission1Desc':'构建符合客户业务需求的网站、应用程序、信息系统和技术服务。','vision.mission2Title':'提供专业且可持续的服务','vision.mission2Desc':'保持工作质量、沟通和技术支持，使每个解决方案都能最优运行。','vision.mission3Title':'推动企业数字化转型','vision.mission3Desc':'帮助企业、组织和机构通过技术提高效率。','vision.mission4Title':'优先考虑创新与可靠性','vision.mission4Desc':'提供现代化、安全、易用且可根据未来需求持续发展的系统。','vision.mission5Title':'通过每个解决方案创造价值','vision.mission5Desc':'让每个想法、流程和技术成为为用户和客户带来真实价值的成果。','services.badge':'服务','services.title':'专为运营需求和业务增长设计的IT解决方案。','services.desc':'我们将软件开发、基础设施建设和实施咨询相结合，帮助企业更高效运营。','services.card1Title':'应用程序开发','services.card1Desc':'开发Web、移动端及内部系统，用于数字化业务流程和客户服务。','services.card2Title':'基础设施与网络','services.card2Desc':'规划并实施安全稳定的IT基础设施、网络及运营环境。','services.card3Title':'IT采购','services.card3Desc':'以高效务实的方式采购硬件、软件及其他技术需求。','insight.badge':'绩效洞察','insight.title':'数据驱动交付，实现更可衡量的成果。','insight.desc':'此图表展示交付增长、实施效果及服务优先级重点。','insight.stat1':'数字工作流效率','insight.stat2':'更快的报告周期','insight.stat3':'稳定性目标','insight.chartBadge':'交付增长概览','insight.chartTitle':'服务构成与影响','insight.chartNote':'演示图表','industries.badge':'服务行业','industries.title':'适用于各类组织和IT实施需求。','industries.desc':'灵活的方法——适合从初创企业到大型企业。','industries.card1Title':'企业与中小企业','industries.card1Desc':'工作流数字化、运营看板和决策支持系统。','industries.card2Title':'零售与分销','industries.card2Desc':'销售、库存、报表及分支机构活动监控集成。','industries.card3Title':'教育与公共服务','industries.card3Desc':'信息系统、服务门户和更有序的数据治理。','industries.card4Title':'工业运营','industries.card4Desc':'网络、监控及现场运营支持解决方案。','portfolio.badge':'能力展示','portfolio.title':'我们可为您的企业提供的解决方案领域示例。','portfolio.card1Title':'管理驾驶舱','portfolio.card1Desc':'简洁的看板，用于监控跨业务单元的KPI、运营、销售和关键数据。','portfolio.card2Title':'面向客户的应用','portfolio.card2Desc':'帮助企业提升客户服务和数字体验的应用程序与门户。','portfolio.card3Title':'基础设施现代化','portfolio.card3Desc':'升级网络、服务器和IT环境，使其更安全、更有序并具备增长能力。','process.badge':'工作流程','process.title':'我们如何确保每个项目保持清晰、有方向且可交付。','process.desc':'结构化工作流程可减少沟通误差，加快验证并保持实施质量。','process.step1Title':'需求发现与梳理','process.step1Desc':'在执行前，我们先梳理业务需求、现有流程和实施目标。','process.step2Title':'解决方案设计','process.step2Desc':'解决方案架构、工作流程和实施优先级与业务需求保持一致。','process.step3Title':'构建与实施','process.step3Desc':'团队以可量化且有文档记录的方式执行开发、部署和配置工作。','process.step4Title':'测试、交付与支持','process.step4Desc':'解决方案经过验证后清晰交付，并提供支持以确保在实际运营中保持稳定。','clients.title':'我们的客户','contact.badge':'联系我们','contact.title':'准备好构建专业的数字系统了吗？','contact.desc':'如果您需要企业官网、内部应用或更完善的IT基础设施，我们可以从规划到实施全程协助。','contact.cta1':'WhatsApp咨询','contact.cta2':'发送邮件','contact.card1':'邮箱','contact.card2':'电话 / WhatsApp','contact.card3':'地址','contact.location':'印度尼西亚加里曼丹','footer.taglinePrefix':'PT Fluxa Tritama Indonesia为现代商业需求提供技术服务和数字解决方案','footer.copySuffix':'保留所有权利。','chatbot.badge':'聊天机器人演示','chatbot.title':'Fluxa助手','chatbot.welcome':'您好！我随时准备解释PT Fluxa Tritama Indonesia的服务。可以询问网站、应用程序、基础设施或初步咨询。','chatbot.quick1':'有哪些服务？','chatbot.quick2':'能做网站吗？','chatbot.quick3':'如何咨询？'}
};

const WA='https://wa.me/6281250653005';
const EM='mailto:official@fluxa.co.id';
const chatR={
  layanan:{
    id:'Kami menyediakan: (1) Application Development — web, mobile, sistem internal; (2) Infrastructure & Network — LAN/WAN, server, security; (3) IT Procurement — hardware & software.\n\nSilakan hubungi kami langsung untuk diskusi kebutuhan Anda:\n📱 WhatsApp: +62 812-5065-3005\n📧 Email: official@fluxa.co.id',
    en:'We provide: (1) Application Development — web, mobile, internal systems; (2) Infrastructure & Network; (3) IT Procurement.\n\nContact us directly to discuss your needs:\n📱 WhatsApp: +62 812-5065-3005\n📧 Email: official@fluxa.co.id',
    zh:'我们提供：(1) 应用程序开发; (2) 基础设施与网络; (3) IT采购。\n\n请直接联系我们讨论您的需求：\n📱 WhatsApp: +62 812-5065-3005\n📧 邮件：official@fluxa.co.id'
  },
  website:{
    id:'Ya, kami membangun company profile, landing page, portal bisnis, dashboard, dan sistem web kustom sesuai kebutuhan bisnis Anda.\n\nYuk diskusi lebih lanjut:\n📱 WhatsApp: +62 812-5065-3005\n📧 Email: official@fluxa.co.id',
    en:'Yes! We build company profiles, landing pages, business portals, dashboards, and custom web systems tailored to your business.\n\nLet\'s discuss further:\n📱 WhatsApp: +62 812-5065-3005\n📧 Email: official@fluxa.co.id',
    zh:'是的，我们构建企业官网、登陆页、业务门户、仪表板和定制Web系统。\n\n欢迎进一步洽谈：\n📱 WhatsApp: +62 812-5065-3005\n📧 邮件：official@fluxa.co.id'
  },
  konsultasi:{
    id:'Konsultasi awal kami gratis! Silakan hubungi kami melalui:\n📱 WhatsApp: +62 812-5065-3005\n📧 Email: official@fluxa.co.id\n\nTim kami siap merespons dan membantu memetakan kebutuhan Anda.',
    en:'Our initial consultation is free! Please contact us via:\n📱 WhatsApp: +62 812-5065-3005\n📧 Email: official@fluxa.co.id\n\nOur team is ready to respond and help map your needs.',
    zh:'初步咨询免费！请通过以下方式联系我们：\n📱 WhatsApp: +62 812-5065-3005\n📧 邮件：official@fluxa.co.id\n\n我们的团队随时准备响应并帮助梳理您的需求。'
  },
  default:{
    id:'Terima kasih sudah menghubungi kami! Untuk diskusi lebih lanjut, silakan hubungi tim PT Fluxa Tritama Indonesia:\n📱 WhatsApp: +62 812-5065-3005\n📧 Email: official@fluxa.co.id',
    en:'Thank you for reaching out! To discuss further, please contact the PT Fluxa Tritama Indonesia team:\n📱 WhatsApp: +62 812-5065-3005\n📧 Email: official@fluxa.co.id',
    zh:'感谢您的联系！如需进一步讨论，请联系PT Fluxa Tritama Indonesia团队：\n📱 WhatsApp: +62 812-5065-3005\n📧 邮件：official@fluxa.co.id'
  }
};

let lang='id', theme='dark', cbOpen=false, counted=false;

/* apply lang */
function applyLang(l){
  lang=l;
  const d=T[l]||T.id;
  document.querySelectorAll('[data-i18n]').forEach(el=>{const k=el.dataset.i18n;if(d[k])el.textContent=d[k]});
  document.querySelectorAll('.lang-b').forEach(b=>b.classList.toggle('active',b.dataset.lang===l));
}

/* apply theme */
function applyTheme(t){
  theme=t;
  document.body.setAttribute('data-theme',t);
  const ic=t==='dark'?'fa-moon':'fa-sun';
  ['th-ic','th-ic-m'].forEach(id=>{const el=document.getElementById(id);if(el)el.className=`fas ${ic} text-sm`});
}

/* scroll reveal */
const obs=new IntersectionObserver(es=>{es.forEach(e=>{if(e.isIntersecting){e.target.classList.add('on');obs.unobserve(e.target)}})},{threshold:.1,rootMargin:'0px 0px -30px 0px'});
document.querySelectorAll('.reveal,.reveal-l,.reveal-r').forEach(el=>obs.observe(el));

/* counters */
function runCounters(){
  if(counted)return; counted=true;
  document.querySelectorAll('.counter').forEach(el=>{
    const t=+el.dataset.target, step=t/40; let cur=0;
    const timer=setInterval(()=>{cur=Math.min(cur+step,t);el.textContent=Math.floor(cur)+'+';if(cur>=t)clearInterval(timer)},35);
  });
}

/* navbar + progress */
const nav=document.getElementById('nav');
const prog=document.getElementById('progress');
const btt=document.getElementById('btt');
window.addEventListener('scroll',()=>{
  const s=window.scrollY,h=document.documentElement.scrollHeight-window.innerHeight;
  nav.classList.toggle('sc',s>60);
  prog.style.width=(h>0?s/h*100:0)+'%';
  btt.classList.toggle('show',s>400);
  if(s>200)runCounters();
},{passive:true});

/* hamburger */
const ham=document.getElementById('ham');
const mobMenu=document.getElementById('mob-menu');
ham.addEventListener('click',()=>{ham.classList.toggle('open');mobMenu.classList.toggle('open')});
mobMenu.querySelectorAll('a').forEach(a=>a.addEventListener('click',()=>{ham.classList.remove('open');mobMenu.classList.remove('open')}));

/* theme */
['th-tog','th-tog-m'].forEach(id=>document.getElementById(id)?.addEventListener('click',()=>applyTheme(theme==='dark'?'light':'dark')));

/* lang */
document.querySelectorAll('.lang-b').forEach(b=>b.addEventListener('click',()=>applyLang(b.dataset.lang)));

/* chart */
const ctx=document.getElementById('svcChart');
if(ctx){new Chart(ctx,{type:'bar',data:{labels:['App Dev','Infrastructure','IT Procurement','Consulting','Support'],datasets:[{data:[38,27,19,10,6],backgroundColor:['rgba(45,212,191,.7)','rgba(56,189,248,.7)','rgba(167,139,250,.7)','rgba(251,191,36,.7)','rgba(251,113,133,.7)'],borderColor:'transparent',borderRadius:8,borderSkipped:false}]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false},tooltip:{backgroundColor:'rgba(13,27,46,.95)',borderColor:'rgba(255,255,255,.1)',borderWidth:1,titleColor:'#f1f5f9',bodyColor:'#94a3b8',callbacks:{label:c=>` ${c.raw}% of projects`}}},scales:{x:{grid:{display:false},ticks:{color:'#64748b',font:{size:11}},border:{display:false}},y:{grid:{color:'rgba(255,255,255,.05)'},ticks:{color:'#64748b',font:{size:11},callback:v=>v+'%'},border:{display:false}}}}})}

/* chatbot */
const fab=document.getElementById('cb-fab'), panel=document.getElementById('cb-panel');
const msgs=document.getElementById('cb-msgs'), form=document.getElementById('cb-form'), inp=document.getElementById('cb-inp');
const toggle=()=>{cbOpen=!cbOpen;panel.classList.toggle('open',cbOpen);if(cbOpen)inp.focus()};
fab.addEventListener('click',toggle);
document.getElementById('cb-close').addEventListener('click',toggle);
function addMsg(txt,type){const d=document.createElement('div');d.className=`cb-bbl ${type==='bot'?'bb-bot':'bb-usr'}`;d.style.whiteSpace='pre-line';d.textContent=txt;msgs.appendChild(d);msgs.scrollTop=msgs.scrollHeight}
function getReply(msg){const lo=msg.toLowerCase();let k='default';if(lo.includes('layana')||lo.includes('service')||lo.includes('服务'))k='layanan';else if(lo.includes('website')||lo.includes('web'))k='website';else if(lo.includes('konsultasi')||lo.includes('consult')||lo.includes('kontak'))k='konsultasi';return chatR[k][lang]||chatR[k].id}
document.querySelectorAll('.cb-qbtn').forEach(b=>b.addEventListener('click',()=>{addMsg(b.textContent,'user');setTimeout(()=>addMsg(chatR[b.dataset.prompt]?.[lang]||chatR[b.dataset.prompt].id,'bot'),600)}));
form.addEventListener('submit',e=>{e.preventDefault();const m=inp.value.trim();if(!m)return;addMsg(m,'user');inp.value='';const t=document.createElement('div');t.className='cb-bbl bb-bot';t.textContent='…';msgs.appendChild(t);msgs.scrollTop=msgs.scrollHeight;setTimeout(()=>{t.textContent=getReply(m);msgs.scrollTop=msgs.scrollHeight},800)});

/* back to top */
btt.addEventListener('click',()=>window.scrollTo({top:0,behavior:'smooth'}));

/* footer year */
document.getElementById('yr').textContent=new Date().getFullYear();

/* init */
applyLang('id');
applyTheme('dark');
</script>
</body>
</html>
