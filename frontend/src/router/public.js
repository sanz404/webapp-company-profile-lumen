import PublicHome from "../pages/Public/Home.vue"
import PublicAbout from "../pages/Public/About.vue"
import PublicBlog from "../pages/Public/Blog.vue"
import PublicBlogDetail from "../pages/Public/BlogDetail.vue"
import PublicContact from "../pages/Public/Contact.vue"
import PublicFaq from "../pages/Public/Faq.vue"
import PublicPortfolio from "../pages/Public/Portfolio.vue"
import PublicPortfolioDetail from "../pages/Public/PortfolioDetail.vue"
import PublicPricing from "../pages/Public/Pricing.vue"
import PublicProfile from "../pages/Public/Profile.vue"
import ChangePassword from "../pages/Public/ChangePassword.vue"

export default [
    {
        path: "/",
        name: "Welcome",
        component: PublicHome
    },
    {
        path: "/home",
        name: "HomePage",
        component: PublicHome
    },
    {
        path: "/about",
        name: "About",
        component: PublicAbout
    },
    {
        path: "/blog",
        name: "Blog",
        component: PublicBlog
    },
    {
        path: "/blog/:slug",
        name: "BlogDetail",
        props: true,
        component: PublicBlogDetail
    },
    {
        path: "/contact",
        name: "Contact",
        component: PublicContact
    },
    {
        path: "/account/profile",
        name: "Profile",
        component: PublicProfile
    },
    {
        path: "/account/password",
        name: "ChangePassword",
        component: ChangePassword
    },
    {
        path: "/faq",
        name: "Faq",
        component: PublicFaq
    },
    {
        path: "/portfolio",
        name: "Portfolio",
        component: PublicPortfolio
    },
    {
        path: "/portfolio/:slug",
        name: "PortfolioDetail",
        props: true,
        component: PublicPortfolioDetail
    },
    {
        path: "/pricing",
        name: "PublicPricing",
        component: PublicPricing
    },
]