/**
 * Sungmi India — Insights & Knowledge (Blogs) Controller
 * Interactive blog modal and card management with dynamic DB data support
 */

const BLOG_ARTICLES_DATA = (typeof window !== 'undefined' && Array.isArray(window.BLOG_ARTICLES_DATA))
  ? window.BLOG_ARTICLES_DATA
  : [
  {
    id: "marine-engineering",
    slug: "marine-engineering",
    category: "MARINE ENGINEERING",
    title: "Why Marine Accommodation Systems Matter in Modern Shipbuilding",
    summary: "Marine accommodation is a critical structural subsystem directly influencing crew endurance, acoustic insulation, vessel balance, and statutory classification compliance.",
    image: "assets/blog_shipbuilding_shipyard.jpg",
    alt: "Marine accommodation engineering and shipbuilding structural overview",
    readTime: "4 min read",
    paragraphs: [
      "Modern commercial and defense vessels spend weeks to months continuously operating in open ocean environments. The living quarters—encompassing cabins, corridors, galleys, mess rooms, and sanitary spaces—serve as the vital lifeline for crew health, rest, and operational alertness.",
      "Engineering effective accommodation systems requires addressing multiple demanding criteria simultaneously:",
      "• Structural Integration & Lightweight Design: Minimizing deadweight while providing high structural rigidity and vibration dampening under rough sea states.\n• Acoustic & Thermal Comfort: Utilizing high-density mineral wool core panels and composite bulkhead constructions to insulate crew quarters from machinery spaces and engine exhaust noise.\n• Class Society Compliance: Adhering strictly to SOLAS (Safety of Life at Sea) mandates, IMO fire safety codes, and international classification guidelines (such as IRS, ABS, DNV, and Lloyd's Register).",
      "Modern shipbuilding treats the accommodation zone as an integrated engineered system, balancing durability, ergonomic utility, and fire integrity to maximize vessel uptime and crew performance."
    ]
  },
  {
    id: "marine-safety",
    slug: "marine-safety",
    category: "MARINE SAFETY",
    title: "The Role of Fire-Resistant Doors in Marine Accommodation",
    summary: "In maritime safety engineering, fire-resistant doors act as vital thermal barriers designed to compartmentalize fire, prevent smoke migration, and preserve emergency evacuation corridors.",
    image: "assets/door.jpg",
    alt: "Marine certified fire-resistant door and safety containment system",
    readTime: "3 min read",
    paragraphs: [
      "At sea, when a fire incident occurs, external assistance is unavailable. Structural containment is the primary line of defense. Marine fire-rated doors (such as A-60, A-0, B-15, and H-120 ratings) are engineered to prevent flame penetration and restrict extreme temperature transmission between structural bulkheads and watertight compartments.",
      "Key Engineering Considerations in Marine Fire Doors:",
      "• Fire Integrity & Insulation Ratings: A-Class fire doors provide structural resistance against flame and gas penetration for up to 60 minutes with controlled cold-face temperature limits, ensuring escape stairwells remain traversable.\n• Acoustic Sealing & Draft Tightness: Marine doors incorporate perimeter intumescent seals and acoustic silicone gaskets to block toxic smoke inhalation and maintain cabin noise reduction.\n• Corrosion-Resistant Hardware: Built with heavy-duty stainless steel hinges, marine-grade mortise locks, three-point latching mechanisms, and self-closing panic hardware designed to function reliably in harsh saline marine air.",
      "Proper specification and installation of certified fire-rated marine doors protect vital navigation spaces, engine perimeters, and crew quarters during critical emergencies."
    ]
  },
  {
    id: "offshore-engineering",
    slug: "offshore-engineering",
    category: "OFFSHORE ENGINEERING",
    title: "Building Accommodation Systems for Offshore Environments",
    summary: "Offshore oil rigs, FPSOs, platforms, and wind substations face extreme environmental loads, saline corrosion, high humidity, and continuous structural vibrations.",
    image: "assets/app_offshore_platform_1787755777035.jpg",
    alt: "Offshore platform and maritime harsh environment accommodation",
    readTime: "4 min read",
    paragraphs: [
      "Unlike standard inland installations, offshore accommodation modules operate under continuous exposure to extreme oceanic conditions—including tropical cyclones, heavy saline mist, severe structural pitching, and volatile hydrocarbon atmospheres.",
      "Specialized Engineering Requirements for Offshore Structures:",
      "• Advanced Corrosion Protection: Bulkheads and framing utilize specialized hot-dip galvanized steel, marine-grade aluminum, or stainless steel alloys with high-durability epoxy and polyurethane coatings to resist saltwater corrosion.\n• Blast & Hazardous Zone Resistance: In proximity to upstream drilling or processing facilities, accommodation walls and doors must meet stringent blast overpressure resistance (H-class fire and blast criteria) and gas-tight sealing.\n• Self-Sufficient Wet Units & Sanitary Infrastructure: Sanitary units and wet modules feature seamless composite floors, anti-slip marine flooring, marine-grade plumbing fixtures, and integrated water management systems that withstand vessel movement and tilt.",
      "Designing offshore living systems demands uncompromising attention to material durability, structural integrity, and life-safety containment."
    ]
  },
  {
    id: "modular-systems",
    slug: "modular-systems",
    category: "MODULAR SYSTEMS",
    title: "Modular Accommodation: Smarter Solutions for Marine Projects",
    summary: "Factory prefabrication of modular cabins and wet units streamlines shipyard schedules, reduces on-board hot work, and ensures consistent quality control under controlled industrial standards.",
    image: "assets/modular-cabins.png",
    alt: "Prefabricated marine modular cabin and plug-and-play assembly system",
    readTime: "3 min read",
    paragraphs: [
      "Traditional stick-built vessel outfitting often leads to congested workspaces on ship decks, extended fabrication timelines, and inconsistent onsite finish quality. Modular accommodation transforms this methodology by moving the assembly process into a controlled factory environment.",
      "Advantages of Modular Marine Systems:",
      "• Plug-and-Play Integration: Pre-assembled modular cabins and wet units arrive at the shipyard complete with integrated wiring conduits, pre-fitted piping manifolds, fire-rated ceiling panels, and certified bulkhead joints ready for immediate hookup.\n• Reduced Vessel Outfitting Time: Shipyards can fabricate the ship's hull and superstructure concurrently with the interior accommodation modules, saving weeks of dockside build time.\n• Rigorous Factory Quality Control: Offsite fabrication allows precision CNC cutting, rigorous pressure testing of sanitary systems, and thorough electrical testing prior to delivery, minimizing shipyard rework and warranty claims.",
      "Modular accommodation architecture is rapidly becoming the industry benchmark for modern commercial shipyards, naval builders, and offshore refit projects."
    ]
  }
];

function initBlogsSection() {
  const modal = document.getElementById('blog-modal');
  const modalBackdrop = document.getElementById('blog-modal-backdrop');
  const modalCloseBtn = document.getElementById('blog-modal-close');
  const modalCategory = document.getElementById('modal-blog-category');
  const modalTitle = document.getElementById('modal-blog-title');
  const modalImage = document.getElementById('modal-blog-image');
  const modalReadTime = document.getElementById('modal-blog-readtime');
  const modalBody = document.getElementById('modal-blog-body');
  const readArticleBtns = document.querySelectorAll('.btn-read-blog');

  if (!modal) return;

  function openBlogModal(blogData) {
    if (!blogData) return;

    if (modalCategory) modalCategory.textContent = blogData.category;
    if (modalTitle) modalTitle.textContent = blogData.title;
    if (modalReadTime) modalReadTime.textContent = blogData.readTime;

    if (modalImage) {
      modalImage.src = blogData.image;
      modalImage.alt = blogData.alt || blogData.title;
    }

    if (modalBody) {
      modalBody.innerHTML = '';
      if (blogData.content) {
        modalBody.innerHTML = blogData.content;
      } else if (Array.isArray(blogData.paragraphs)) {
        blogData.paragraphs.forEach(pText => {
          if (pText.startsWith('•')) {
            const ul = document.createElement('ul');
            ul.className = 'modal-blog-list';
            const items = pText.split('\n');
            items.forEach(item => {
              const li = document.createElement('li');
              const cleanText = item.replace(/^•\s*/, '');
              if (cleanText.includes(':')) {
                const parts = cleanText.split(':');
                li.innerHTML = `<strong>${parts[0]}:</strong>${parts.slice(1).join(':')}`;
              } else {
                li.textContent = cleanText;
              }
              ul.appendChild(li);
            });
            modalBody.appendChild(ul);
          } else {
            const p = document.createElement('p');
            p.className = 'modal-blog-paragraph';
            p.textContent = pText;
            modalBody.appendChild(p);
          }
        });
      }
    }

    modal.classList.add('active');
    document.body.classList.add('modal-open');
    modal.setAttribute('aria-hidden', 'false');
    if (modalCloseBtn) modalCloseBtn.focus();
  }

  function closeBlogModal() {
    modal.classList.remove('active');
    document.body.classList.remove('modal-open');
    modal.setAttribute('aria-hidden', 'true');
  }

  window.openBlogArticle = function (id) {
    const dataset = (typeof window !== 'undefined' && Array.isArray(window.BLOG_ARTICLES_DATA) && window.BLOG_ARTICLES_DATA.length)
      ? window.BLOG_ARTICLES_DATA
      : BLOG_ARTICLES_DATA;

    const blogData = dataset.find(b => String(b.id) === String(id) || (b.slug && String(b.slug) === String(id)));
    if (blogData) {
      openBlogModal(blogData);
    }
  };

  window.closeBlogModal = closeBlogModal;

  readArticleBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const blogId = btn.getAttribute('data-blog-id');
      window.openBlogArticle(blogId);
    });
  });

  if (modalCloseBtn) {
    modalCloseBtn.addEventListener('click', (e) => {
      e.preventDefault();
      closeBlogModal();
    });
  }

  if (modalBackdrop) {
    modalBackdrop.addEventListener('click', closeBlogModal);
  }

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && modal.classList.contains('active')) {
      closeBlogModal();
    }
  });
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initBlogsSection);
} else {
  initBlogsSection();
}
