import { PremiumNavbar, Hero } from "@/components/landing/Hero";
import { Footer } from "@/components/Footer";
import {
  CategoriesPills,
  BookOfMonth,
  Genres,
  NewAdded,
  Deals,
  BestSellers,
  Authors,
  Trust,
  PromoBanner,
} from "@/components/landing/Sections";

const Index = () => {
  return (
    <div className="min-h-screen flex flex-col">
      <PremiumNavbar />
      <main className="flex-1">
        <Hero />
        <CategoriesPills />
        <BookOfMonth />
        <Genres />
        <NewAdded />
        <Deals />
        <BestSellers />
        <Authors />
        <Trust />
        <PromoBanner />
      </main>
      <Footer />
    </div>
  );
};

export default Index;
