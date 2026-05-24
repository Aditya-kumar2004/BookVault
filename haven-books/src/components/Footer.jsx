import { Link } from "react-router-dom";
import { Facebook, Twitter, Instagram, Youtube, Mail, Phone, MapPin, BookOpen } from "lucide-react";

/* ────────────────────────────────────────────────────────
   PAYMENT LOGO SVGs — dark-themed (no white backgrounds)
   Each renders its brand identity on transparent/dark bg
──────────────────────────────────────────────────────── */
const MastercardSVG = () => (
  <svg viewBox="0 0 38 24" width="38" height="24" xmlns="http://www.w3.org/2000/svg">
    <circle cx="14" cy="12" r="9" fill="#EB001B" opacity="0.92" />
    <circle cx="24" cy="12" r="9" fill="#F79E1B" opacity="0.92" />
    <path d="M19 5.2a9 9 0 0 1 0 13.6A9 9 0 0 1 19 5.2z" fill="#FF5F00" />
  </svg>
);

const VisaSVG = () => (
  <svg viewBox="0 0 48 24" width="48" height="24" xmlns="http://www.w3.org/2000/svg">
    <text x="50%" y="50%" dominantBaseline="middle" textAnchor="middle"
      fontFamily="Arial Black, Arial, sans-serif" fontWeight="900" fontSize="16"
      fill="#FFFFFF" letterSpacing="1">VISA</text>
  </svg>
);

const AmexSVG = () => (
  <svg viewBox="0 0 48 24" width="48" height="24" xmlns="http://www.w3.org/2000/svg">
    <text x="50%" y="50%" dominantBaseline="middle" textAnchor="middle"
      fontFamily="Arial, sans-serif" fontWeight="800" fontSize="12"
      fill="#60A5FA" letterSpacing="1">AMEX</text>
  </svg>
);

const ApplePaySVG = () => (
  <svg viewBox="0 0 64 24" width="64" height="24" xmlns="http://www.w3.org/2000/svg">
    {/* Apple  */}
    <path d="M13 5.8c.7-.9 1.2-2.1 1-3.3-1 .1-2.3.7-3 1.6-.6.8-1.1 2-.9 3.1 1 .1 2.1-.5 2.9-1.4z" fill="white" />
    <path d="M14 7.8c-1.6-.1-3 .9-3.8.9-.8 0-2-1-3.2-1-1.7 0-3.2 1-4 2.5-1.7 3 -.5 7.4 1.2 9.8.8 1.2 1.8 2.5 3.1 2.5 1.2-.1 1.7-.8 3.1-.8s1.9.8 3.2.8c1.3-.1 2.2-1.3 3-2.5.6-.9 1-1.8 1.3-2.7-3.4-1.3-2.9-6.4.6-7.7-.7-1.4-2-2.7-3.5-2.8z" fill="white" />
    {/* Pay */}
    <text x="42" y="50%" dominantBaseline="middle" textAnchor="middle"
      fontFamily="SF Pro, -apple-system, sans-serif" fontWeight="600" fontSize="13"
      fill="white">Pay</text>
  </svg>
);

const PayPalSVG = () => (
  <svg viewBox="0 0 64 24" width="64" height="24" xmlns="http://www.w3.org/2000/svg">
    <text x="50%" y="50%" dominantBaseline="middle" textAnchor="middle"
      fontFamily="Arial, sans-serif" fontWeight="700" fontSize="13">
      <tspan fill="#96C8F0">Pay</tspan><tspan fill="#012169">Pal</tspan>
    </text>
  </svg>
);

const GooglePaySVG = () => (
  <svg viewBox="0 0 72 24" width="72" height="24" xmlns="http://www.w3.org/2000/svg">
    <text x="4" y="50%" dominantBaseline="middle" textAnchor="start"
      fontFamily="Arial, sans-serif" fontWeight="700" fontSize="14">
      <tspan fill="#4285F4">G</tspan><tspan fill="#DB4437">o</tspan>
      <tspan fill="#F4B400">o</tspan><tspan fill="#4285F4">g</tspan>
      <tspan fill="#0F9D58">l</tspan><tspan fill="#DB4437">e</tspan>
    </text>
    <text x="58" y="50%" dominantBaseline="middle" textAnchor="middle"
      fontFamily="Arial, sans-serif" fontWeight="600" fontSize="13"
      fill="rgba(255,255,255,0.80)">Pay</text>
  </svg>
);

const ClearpaySVG = () => (
  <svg viewBox="0 0 80 24" width="80" height="24" xmlns="http://www.w3.org/2000/svg">
    <text x="38" y="50%" dominantBaseline="middle" textAnchor="middle"
      fontFamily="Arial, sans-serif" fontWeight="700" fontSize="12"
      fill="#B2FCE4" letterSpacing="-0.2">clearpay ✦</text>
  </svg>
);

const PAYMENTS = [
  { key: "Mastercard", SVG: MastercardSVG, bg: "rgba(255,255,255,0.04)" },
  { key: "Visa", SVG: VisaSVG, bg: "rgba(255,255,255,0.04)" },
  { key: "Amex", SVG: AmexSVG, bg: "rgba(37,99,235,0.18)" },
  { key: "Apple Pay", SVG: ApplePaySVG, bg: "rgba(255,255,255,0.04)" },
  { key: "PayPal", SVG: PayPalSVG, bg: "rgba(0,58,160,0.22)" },
  { key: "Google Pay", SVG: GooglePaySVG, bg: "rgba(255,255,255,0.04)" },
  { key: "Clearpay", SVG: ClearpaySVG, bg: "rgba(178,252,228,0.10)" },
];

/* ─────────────────────────────────────────── FOOTER ── */
export function Footer() {
  return (
    <footer style={{ backgroundColor: "#0D1B2A" }} className="text-white">

      {/* ── Main grid ──────────────────────────────────── */}
      <div className="container py-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">

        {/* Brand */}
        <div className="lg:col-span-1">
          <Link to="/" className="flex items-center gap-3 group mb-5">
            <div
              className="h-12 w-12 rounded-2xl flex items-center justify-center"
              style={{
                background: "linear-gradient(135deg,#1B4332,#2d6a4f)",
                boxShadow: "0 6px 20px rgba(27,67,50,0.55), inset 0 1px 0 rgba(255,255,255,0.12)",
              }}
            >
              <BookOpen className="h-6 w-6 text-white" />
            </div>
            <div className="flex flex-col leading-none">
              <span className="font-display text-2xl font-extrabold tracking-tight">
                Book<span style={{ color: "#F4623A" }}>Vault</span>
              </span>
              <span className="text-[9px] uppercase tracking-[0.22em] text-white/35 font-semibold mt-1">
                Premium Book Store
              </span>
            </div>
          </Link>

          <p className="text-sm text-white/45 leading-relaxed max-w-xs">
            The next chapter in your reading journey. Over 2 million titles, curated by
            passionate readers — delivered to your door.
          </p>

          {/* Social */}
          <div className="flex gap-2.5 mt-7">
            {[
              { Icon: Facebook, label: "Facebook" },
              { Icon: Twitter, label: "Twitter" },
              { Icon: Instagram, label: "Instagram" },
              { Icon: Youtube, label: "YouTube" },
            ].map(({ Icon, label }) => (
              <a key={label} href="#" aria-label={label}
                className="h-10 w-10 rounded-xl flex items-center justify-center transition-all duration-200"
                style={{ background: "rgba(255,255,255,0.06)", border: "1px solid rgba(255,255,255,0.08)" }}
                onMouseEnter={(e) => { e.currentTarget.style.background = "#F4623A"; e.currentTarget.style.borderColor = "#F4623A"; }}
                onMouseLeave={(e) => { e.currentTarget.style.background = "rgba(255,255,255,0.06)"; e.currentTarget.style.borderColor = "rgba(255,255,255,0.08)"; }}
              >
                <Icon className="h-4 w-4 text-white/70" />
              </a>
            ))}
          </div>
        </div>

        {/* Quick Links */}
        <div>
          <h4 className="font-display text-base font-bold mb-5 text-white">Quick Links</h4>
          <ul className="space-y-3">
            {["Home", "Browse Books", "New Arrivals", "Deals & Offers", "Authors", "About Us"].map((l) => (
              <li key={l}>
                <a href="#" className="text-sm text-white/45 hover:text-accent transition-colors duration-200 flex items-center gap-1.5 group">
                  <span className="w-0 group-hover:w-3 h-px bg-accent transition-all duration-200 inline-block" />
                  {l}
                </a>
              </li>
            ))}
          </ul>
        </div>

        {/* Categories */}
        <div>
          <h4 className="font-display text-base font-bold mb-5 text-white">Categories</h4>
          <ul className="space-y-3">
            {["Fiction", "Fantasy", "Non-Fiction", "Thriller", "Romance", "Mystery", "Self-Help", "Biography"].map((l) => (
              <li key={l}>
                <a href="#" className="text-sm text-white/45 hover:text-accent transition-colors duration-200 flex items-center gap-1.5 group">
                  <span className="w-0 group-hover:w-3 h-px bg-accent transition-all duration-200 inline-block" />
                  {l}
                </a>
              </li>
            ))}
          </ul>
        </div>

        {/* Contact + Payments */}
        <div>
          <h4 className="font-display text-base font-bold mb-5 text-white">Contact Us</h4>
          <ul className="space-y-4 mb-8">
            <li className="flex items-start gap-3 text-sm text-white/50">
              <Mail className="h-4 w-4 mt-0.5 text-accent shrink-0" />
              <span>support@bookvault.io</span>
            </li>
            <li className="flex items-start gap-3 text-sm text-white/50">
              <Phone className="h-4 w-4 mt-0.5 text-accent shrink-0" />
              <span>+1 (555) 010-1234</span>
            </li>
            <li className="flex items-start gap-3 text-sm text-white/50">
              <MapPin className="h-4 w-4 mt-0.5 text-accent shrink-0" />
              <span>123 Reader Lane, New York, NY 10001</span>
            </li>
          </ul>

          {/* Payment logos — dark themed, color-matched */}
          <div>
            <p className="text-[10px] uppercase tracking-[0.2em] text-white/30 font-bold mb-3">
              Accepted Payments
            </p>
            <div className="flex flex-wrap gap-2.5">
              {PAYMENTS.map(({ key, SVG, bg }) => (
                <div key={key} title={key}
                  className="flex items-center justify-center transition-all duration-200 hover:scale-110"
                  style={{
                    background: bg,
                    border: "1px solid rgba(255,255,255,0.12)",
                    borderRadius: "50%",
                    width: 40,
                    height: 40,
                    flexShrink: 0,
                  }}
                >
                  <SVG />
                </div>
              ))}
            </div>
          </div>
        </div>
      </div>

      {/* ── Bottom bar ─────────────────────────────────── */}
      <div className="border-t" style={{ borderColor: "rgba(255,255,255,0.06)" }}>
        <div className="container py-5 flex flex-col md:flex-row items-center justify-between gap-3 text-xs text-white/28">
          <div className="flex items-center gap-2">
            <BookOpen className="h-3.5 w-3.5 text-accent/70" />
            <p>© {new Date().getFullYear()} BookVault, Inc. All rights reserved.</p>
          </div>
          <div className="flex gap-5">
            {["Privacy Policy", "Terms of Service", "Cookie Policy", "Sitemap"].map((l) => (
              <a key={l} href="#" className="hover:text-accent transition-colors duration-200">{l}</a>
            ))}
          </div>
        </div>
      </div>
    </footer>
  );
}
