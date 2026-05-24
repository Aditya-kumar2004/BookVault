import { useLocation, Link, useNavigate } from "react-router-dom";
import { useEffect } from "react";
import { motion } from "framer-motion";
import { BookOpen, Home, ShoppingBag, LayoutDashboard, Compass, ArrowLeft } from "lucide-react";
import { Button } from "@/components/ui/button";

const FloatingLetters = () => {
  const items = [
    { text: "A", x: -60, y: -90, delay: 0.1, scale: 0.9 },
    { text: "z", x: 70, y: -100, delay: 0.5, scale: 1.1 },
    { text: "?", x: -35, y: -120, delay: 0.9, scale: 1.0 },
    { text: "📚", x: 50, y: -75, delay: 1.3, scale: 0.85 },
    { text: "B", x: -80, y: -65, delay: 1.7, scale: 1.05 },
    { text: "✎", x: 30, y: -130, delay: 2.1, scale: 0.75 },
    { text: "o", x: -20, y: -150, delay: 2.5, scale: 1.2 },
    { text: "k", x: 80, y: -55, delay: 2.9, scale: 0.95 },
  ];

  return (
    <div className="absolute inset-0 pointer-events-none overflow-visible">
      {items.map((item, index) => (
        <motion.span
          key={index}
          className="absolute text-primary/30 dark:text-primary-foreground/30 font-display font-semibold text-lg select-none"
          initial={{ opacity: 0, y: 30, x: 0, scale: 0.5 }}
          animate={{
            opacity: [0, 0.8, 0],
            y: [30, item.y * 0.6, item.y],
            x: [0, item.x * 0.5, item.x],
            scale: [0.5, item.scale, 0.3],
          }}
          transition={{
            duration: 5,
            repeat: Infinity,
            delay: item.delay,
            ease: "easeInOut",
          }}
          style={{
            left: "50%",
            top: "50%",
            transform: "translate(-50%, -50%)",
          }}
        >
          {item.text}
        </motion.span>
      ))}
    </div>
  );
};

const FloatingBook = () => {
  return (
    <div className="relative w-72 h-56 mx-auto mb-10 flex items-center justify-center perspective-1000">
      {/* Dynamic Background soft glow */}
      <div className="absolute w-44 h-44 bg-accent/15 rounded-full blur-3xl" />
      <div className="absolute w-52 h-36 bg-primary/10 rounded-full blur-2xl rotate-45" />
      
      {/* Animated Book wrapper */}
      <motion.div 
        animate={{ y: [0, -14, 0] }}
        transition={{ duration: 4.5, repeat: Infinity, ease: "easeInOut" }}
        className="relative z-10 w-56 h-36 flex cursor-pointer group select-none"
        style={{ transformStyle: "preserve-3d" }}
      >
        {/* Left page */}
        <motion.div 
          whileHover={{ rotateY: -22, scale: 1.06 }}
          transition={{ type: "spring", stiffness: 150, damping: 12 }}
          className="w-1/2 h-full bg-card border-y-2 border-l-2 border-primary/20 dark:border-primary/40 rounded-l-2xl shadow-xl origin-right p-4 flex flex-col justify-between relative overflow-hidden"
          style={{ transformStyle: "preserve-3d", backfaceVisibility: "hidden" }}
        >
          {/* Inner shadow/gradient crease */}
          <div className="absolute top-0 right-0 w-4 h-full bg-gradient-to-l from-foreground/10 to-transparent pointer-events-none" />
          
          {/* Page lines representing written story */}
          <div className="space-y-2 opacity-50 dark:opacity-40">
            <div className="h-1.5 bg-foreground/60 rounded w-5/6" />
            <div className="h-1.5 bg-foreground/60 rounded w-full" />
            <div className="h-1.5 bg-foreground/60 rounded w-4/5" />
            <div className="h-1.5 bg-foreground/60 rounded w-full" />
          </div>
          
          {/* Big Page '4' */}
          <div className="text-right text-6xl font-display font-black text-primary dark:text-primary-foreground/90 leading-none select-none tracking-tight">
            4
          </div>
        </motion.div>

        {/* Book Spine Center Crease */}
        <div className="w-3 h-full bg-primary dark:bg-primary/80 shadow-2xl z-20 self-center rounded-sm flex flex-col justify-between py-1 relative">
          <div className="absolute inset-0 bg-gradient-to-r from-black/20 via-transparent to-black/20" />
          <div className="w-[1px] h-full bg-white/20 mx-auto" />
        </div>

        {/* Right page */}
        <motion.div 
          whileHover={{ rotateY: 22, scale: 1.06 }}
          transition={{ type: "spring", stiffness: 150, damping: 12 }}
          className="w-1/2 h-full bg-card border-y-2 border-r-2 border-primary/20 dark:border-primary/40 rounded-r-2xl shadow-xl origin-left p-4 flex flex-col justify-between relative overflow-hidden"
          style={{ transformStyle: "preserve-3d", backfaceVisibility: "hidden" }}
        >
          {/* Inner shadow/gradient crease */}
          <div className="absolute top-0 left-0 w-4 h-full bg-gradient-to-r from-foreground/10 to-transparent pointer-events-none" />

          {/* Big Page '4' */}
          <div className="text-left text-6xl font-display font-black text-primary dark:text-primary-foreground/90 leading-none select-none tracking-tight">
            4
          </div>

          {/* Page lines representing written story */}
          <div className="space-y-2 opacity-50 dark:opacity-40">
            <div className="h-1.5 bg-foreground/60 rounded w-full" />
            <div className="h-1.5 bg-foreground/60 rounded w-3/4" />
            <div className="h-1.5 bg-foreground/60 rounded w-full" />
            <div className="h-1.5 bg-foreground/60 rounded w-5/6" />
          </div>
        </motion.div>

        {/* Floating Coral Badge '0' over the spine */}
        <motion.div 
          whileHover={{ scale: 1.15, rotate: 10 }}
          className="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-30 flex items-center justify-center"
        >
          <div className="w-12 h-12 bg-accent text-accent-foreground text-2xl font-display font-extrabold rounded-full flex items-center justify-center shadow-lg border-4 border-card transition-all duration-300">
            0
          </div>
        </motion.div>
      </motion.div>

      {/* Floating Letters Particle System */}
      <FloatingLetters />
    </div>
  );
};

const NotFound = () => {
  const location = useLocation();
  const navigate = useNavigate();

  useEffect(() => {
    console.error("404 Error: User attempted to access non-existent route:", location.pathname);
  }, [location.pathname]);

  const navItems = [
    {
      title: "Browse Catalog",
      description: "Discover masterpieces in our extensive library catalog.",
      icon: BookOpen,
      path: "/books",
      color: "text-emerald-600 dark:text-emerald-400 bg-emerald-500/10",
    },
    {
      title: "Your Dashboard",
      description: "Access your wishlist, purchases, and reading statistics.",
      icon: LayoutDashboard,
      path: "/dashboard",
      color: "text-indigo-600 dark:text-indigo-400 bg-indigo-500/10",
    },
    {
      title: "Shopping Cart",
      description: "Review details of items you have collected to read.",
      icon: ShoppingBag,
      path: "/cart",
      color: "text-rose-600 dark:text-rose-400 bg-rose-500/10",
    },
    {
      title: "Back to Home",
      description: "Go straight to the main page of Haven Books.",
      icon: Home,
      path: "/",
      color: "text-amber-600 dark:text-amber-400 bg-amber-500/10",
    },
  ];

  return (
    <div className="relative min-h-screen w-full flex flex-col items-center justify-center bg-background text-foreground px-6 py-16 overflow-hidden md:py-24">
      {/* Ambient background glows */}
      <div className="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] rounded-full bg-primary/5 dark:bg-primary/3 blur-[120px] pointer-events-none" />
      <div className="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] rounded-full bg-accent/5 dark:bg-accent/3 blur-[120px] pointer-events-none" />
      
      {/* Decorative library lines background */}
      <div className="absolute inset-0 bg-[linear-gradient(rgba(0,0,0,0.015)_1px,transparent_1px)] bg-[size:100%_48px] pointer-events-none opacity-40 dark:opacity-10" />

      <div className="max-w-4xl w-full text-center relative z-10 flex flex-col items-center">
        {/* Animated Book Illustration */}
        <FloatingBook />

        {/* Literary Typography Section */}
        <motion.div
          initial={{ opacity: 0, y: 15 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6 }}
          className="space-y-4 max-w-2xl"
        >
          <span className="text-sm font-semibold tracking-[0.25em] text-accent uppercase font-sans">
            Chapter 404
          </span>
          <h1 className="text-4xl md:text-5xl font-display font-bold text-foreground text-balance">
            The Lost Page
          </h1>
          <p className="text-base md:text-lg text-muted-foreground leading-relaxed text-balance">
            It seems you've wandered into an unwritten part of the story, or the page was torn out from our catalog. Let's guide you back to the main narrative.
          </p>
        </motion.div>

        {/* Primary Action Buttons */}
        <motion.div
          initial={{ opacity: 0, y: 15 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6, delay: 0.2 }}
          className="flex flex-col sm:flex-row gap-4 mt-8 w-full sm:w-auto"
        >
          <Button 
            variant="outline" 
            onClick={() => navigate(-1)} 
            className="w-full sm:w-auto gap-2 border-primary/20 dark:border-primary/40 hover:bg-muted text-base h-11 px-6 transition-all duration-300 hover:shadow-soft"
          >
            <ArrowLeft className="w-4 h-4 transition-transform duration-300 group-hover:-translate-x-1" />
            Go Back
          </Button>
          
          <Button 
            variant="coral" 
            asChild
            className="w-full sm:w-auto gap-2 text-base h-11 px-6 shadow-soft"
          >
            <Link to="/books">
              <Compass className="w-4 h-4" />
              Explore Library
            </Link>
          </Button>
        </motion.div>

        {/* Separator */}
        <motion.div
          initial={{ opacity: 0 }}
          animate={{ opacity: 1 }}
          transition={{ duration: 0.6, delay: 0.3 }}
          className="w-24 h-[1px] bg-border my-12"
        />

        {/* Dynamic Quick Navigation Portal */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, delay: 0.4 }}
          className="w-full space-y-6"
        >
          <h3 className="text-lg font-display font-semibold text-foreground tracking-wide">
            Where would you like to explore next?
          </h3>
          
          <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 w-full text-left">
            {navItems.map((item, idx) => {
              const Icon = item.icon;
              return (
                <Link
                  key={idx}
                  to={item.path}
                  className="group relative flex flex-col p-5 bg-card hover:bg-card/85 border border-border/80 dark:border-border/30 rounded-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-soft overflow-hidden"
                >
                  {/* Subtle hover glow accent border */}
                  <div className="absolute inset-0 border-b-2 border-transparent group-hover:border-accent/40 transition-all duration-300" />
                  
                  <div className={`w-10 h-10 rounded-lg flex items-center justify-center ${item.color} mb-4 transition-transform duration-300 group-hover:scale-110`}>
                    <Icon className="w-5 h-5" />
                  </div>
                  
                  <h4 className="font-semibold text-sm text-foreground mb-1 group-hover:text-accent transition-colors duration-200">
                    {item.title}
                  </h4>
                  
                  <p className="text-xs text-muted-foreground leading-relaxed">
                    {item.description}
                  </p>
                </Link>
              );
            })}
          </div>
        </motion.div>
      </div>
    </div>
  );
};

export default NotFound;
