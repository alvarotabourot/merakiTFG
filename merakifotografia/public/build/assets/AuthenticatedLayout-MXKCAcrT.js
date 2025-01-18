import{j as S,o as s,l as n,w as o,x as y,n as z,u as t,s as g,r as b,Q as O,f as q,c as h,b as a,a as l,m as u,d as i}from"./app-Ciu3P-SA.js";import{A as I}from"./ApplicationLogo-DUo0UlGc.js";import D from"./ReportajesForm-CSJmx6Js.js";const f={__name:"NavLink",props:{href:{type:String,required:!0},active:{type:Boolean}},setup(v){const c=v,d=S(()=>c.active?"inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out":"inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out");return(r,_)=>(s(),n(t(g),{href:v.href,class:z(d.value)},{default:o(()=>[y(r.$slots,"default")]),_:3},8,["href","class"]))}},p={__name:"ResponsiveNavLink",props:{href:{type:String,required:!0},active:{type:Boolean}},setup(v){const c=v,d=S(()=>c.active?"block w-full ps-3 pe-4 py-2 border-l-4 border-indigo-400 text-start text-base font-medium text-indigo-700 bg-indigo-50 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 transition duration-150 ease-in-out":"block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out");return(r,_)=>(s(),n(t(g),{href:v.href,class:z(d.value)},{default:o(()=>[y(r.$slots,"default")]),_:3},8,["href","class"]))}},E={class:"min-h-screen bg-gray-100"},H={class:"bg-white border-b border-gray-200 shadow-md"},Q={class:"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"},T={class:"flex justify-between h-20 items-center"},U={class:"flex items-center"},G={class:"hidden md:flex space-x-6 items-center"},J={key:6,class:"flex space-x-4 ml-auto"},K=a("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"2",stroke:"currentColor",class:"w-6 h-6"},[a("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M4 6h16M4 12h16M4 18h16"})],-1),W=[K],X={key:0,class:"md:hidden bg-white border-t border-gray-200 shadow-lg"},Y={class:"pt-4 pb-3 space-y-1"},Z={class:"flex"},ee={key:4,class:"space-y-1"},te={class:"w-[22rem] md:w-[70rem] max-w-lg bg-white rounded-lg shadow-lg"},re=a("svg",{xmlns:"http://www.w3.org/2000/svg",class:"h-6 w-6",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor","stroke-width":"2"},[a("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M12 4v16m8-8H4"})],-1),oe=[re],se={class:"max-w-lg w-full bg-white rounded-lg shadow-lg p-8"},ae=a("h2",{class:"text-3xl font-semibold text-center mb-4"},"¡Bienvenido! ¿Como te gustaría registrarte?",-1),le={class:"flex flex-col gap-4"},de={__name:"AuthenticatedLayout",setup(v){b(!1);const c=b(!1),d=b(!1),{props:r}=O(),_=b(r.categorias),x=b(!1),w=()=>{x.value=!x.value},k=()=>{c.value=!c.value},P=()=>{d.value=!d.value},V=()=>{x.value=!1},j=e=>{e.target.classList.contains("div-overlay")&&(x.value=!1,c.value=!1,d.value=!1)};return(e,ie)=>{var C,M,B,F,R,L,N,$,A;const m=q("font-awesome-icon");return s(),h("div",null,[a("div",E,[a("nav",H,[a("div",Q,[a("div",T,[a("div",U,[l(t(g),{href:e.route("welcome")},{default:o(()=>[l(I,{class:"block h-36 w-auto fill-current text-gray-800"})]),_:1},8,["href"])]),a("div",G,[l(f,{href:e.route("welcome"),active:e.route().current("welcome"),class:"text-purple-600 hover:text-purple-800"},{default:o(()=>[u(" Inicio ")]),_:1},8,["href","active"]),l(f,{href:e.route("categorias"),active:e.route().current("categorias"),class:"text-purple-600 hover:text-purple-800"},{default:o(()=>[u(" Categorías ")]),_:1},8,["href","active"]),(C=t(r).auth)!=null&&C.user?(s(),n(f,{key:0,href:e.route("mis_favoritos"),active:e.route().current("mis_favoritos"),class:"text-purple-600 hover:text-purple-800"},{default:o(()=>[u(" Mis Favoritos ")]),_:1},8,["href","active"])):i("",!0),((M=t(r).auth.user)==null?void 0:M.rol_id)===1?(s(),n(f,{key:1,href:e.route("paneldeadministrador"),active:e.route().current("paneldeadministrador"),class:"text-purple-600 hover:text-purple-800"},{default:o(()=>[u(" Panel de Administrador ")]),_:1},8,["href","active"])):i("",!0),((B=t(r).auth.user)==null?void 0:B.rol_id)===2?(s(),n(f,{key:2,href:e.route("mis_reportajes"),active:e.route().current("mis_reportajes"),class:"text-purple-600 hover:text-purple-800"},{default:o(()=>[u(" Mis Reportajes ")]),_:1},8,["href","active"])):i("",!0),((F=t(r).auth.user)==null?void 0:F.rol_id)===2?(s(),n(f,{key:3,href:e.route("user.show",t(r).auth.user.id),active:e.route().current("user.show"),class:"text-purple-600 hover:text-purple-800"},{default:o(()=>[u(" Perfil ")]),_:1},8,["href","active"])):i("",!0),t(r).auth.user?(s(),n(f,{key:4,href:e.route("profile.edit"),class:"text-purple-600 text-[16px] hover:text-purple-800"},{default:o(()=>[l(m,{icon:["fas","user-gear"]})]),_:1},8,["href"])):i("",!0),t(r).auth.user?(s(),n(f,{key:5,href:e.route("logout"),method:"post",as:"button",class:"text-red-600 text-[16px] hover:text-red-800"},{default:o(()=>[l(m,{icon:["fas","right-from-bracket"]})]),_:1},8,["href"])):i("",!0),t(r).auth.user?i("",!0):(s(),h("div",J,[l(t(g),{href:e.route("login"),class:"rounded-full px-5 py-2 bg-purple-600 hover:bg-purple-700 text-white"},{default:o(()=>[u(" Log in ")]),_:1},8,["href"]),a("button",{onClick:k,class:"rounded-full px-5 py-2 bg-purple-600 hover:bg-purple-700 text-white"}," Register ")]))]),a("div",{class:"md:hidden flex items-center"},[a("button",{onClick:P,class:"text-purple-600 hover:text-purple-800 focus:outline-none"},W)])])]),d.value?(s(),h("div",X,[a("div",Y,[l(p,{href:e.route("welcome"),active:e.route().current("welcome"),class:"text-purple-600 hover:text-purple-800"},{default:o(()=>[u(" Inicio ")]),_:1},8,["href","active"]),l(p,{href:e.route("categorias"),active:e.route().current("categorias"),class:"text-purple-600 hover:text-purple-800"},{default:o(()=>[u(" Categorías ")]),_:1},8,["href","active"]),(R=t(r).auth)!=null&&R.user?(s(),n(p,{key:0,href:e.route("mis_favoritos"),active:e.route().current("mis_favoritos"),class:"text-purple-600 hover:text-purple-800"},{default:o(()=>[u(" Mis Favoritos ")]),_:1},8,["href","active"])):i("",!0),((L=t(r).auth.user)==null?void 0:L.rol_id)===1?(s(),n(p,{key:1,href:e.route("paneldeadministrador"),active:e.route().current("paneldeadministrador"),class:"text-purple-600 hover:text-purple-800"},{default:o(()=>[u(" Panel de Administrador ")]),_:1},8,["href","active"])):i("",!0),((N=t(r).auth.user)==null?void 0:N.rol_id)===2?(s(),n(p,{key:2,href:e.route("mis_reportajes"),active:e.route().current("mis_reportajes"),class:"text-purple-600 hover:text-purple-800"},{default:o(()=>[u(" Mis Reportajes ")]),_:1},8,["href","active"])):i("",!0),(($=t(r).auth.user)==null?void 0:$.rol_id)===2?(s(),n(p,{key:3,href:e.route("user.show",t(r).auth.user.id),active:e.route().current("user.show"),class:"text-purple-600 hover:text-purple-800"},{default:o(()=>[u(" Perfil ")]),_:1},8,["href","active"])):i("",!0),a("div",Z,[t(r).auth.user?(s(),n(p,{key:0,href:e.route("profile.edit"),class:"text-purple-600 text-[16px] w-12 hover:text-purple-800"},{default:o(()=>[l(m,{icon:["fas","user-gear"]})]),_:1},8,["href"])):i("",!0),t(r).auth.user?(s(),n(p,{key:1,href:e.route("logout"),method:"post",as:"button",class:"text-red-600 text-[16px] w-12 hover:text-red-800"},{default:o(()=>[l(m,{icon:["fas","right-from-bracket"]})]),_:1},8,["href"])):i("",!0)]),t(r).auth.user?i("",!0):(s(),h("div",ee,[l(t(g),{href:e.route("login"),class:"block text-center py-2 text-purple-600 hover:bg-purple-100"},{default:o(()=>[u("Log in")]),_:1},8,["href"]),a("button",{onClick:k,class:"block w-full text-center py-2 text-purple-600 hover:bg-purple-100"},"Register")]))])])):i("",!0)]),x.value?(s(),h("div",{key:0,class:"fixed inset-0 z-50 flex items-center justify-center div-overlay bg-black bg-opacity-50 backdrop-filter backdrop-blur-sm",onClick:j},[a("div",te,[l(D,{categorias:_.value,onFormSubmitted:V,onCloseForm:w},null,8,["categorias"])])])):((A=t(r).auth.user)==null?void 0:A.rol_id)===2?(s(),h("button",{key:1,class:"fixed bottom-5 right-5 bg-green-600 text-white rounded-full z-10 p-4 shadow-lg hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-blue-300",onClick:w},oe)):i("",!0),c.value&&!t(r).auth.user?(s(),h("div",{key:2,class:"fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 div-overlay",onClick:j},[a("div",se,[ae,a("div",le,[l(t(g),{href:e.route("register"),class:"btn flex items-center justify-center gap-2 bg-purple-500 hover:bg-purple-600 text-white text-xl font-semibold py-2 px-4 rounded-lg shadow-md transition-all duration-300 ease-in-out transform hover:scale-105"},{default:o(()=>[l(m,{icon:["fas","fa-user-circle"]}),u(" Usuario ")]),_:1},8,["href"]),l(t(g),{href:e.route("registerFotografo"),class:"btn flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-xl text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-all duration-300 ease-in-out transform hover:scale-105"},{default:o(()=>[l(m,{icon:["fas","fa-camera-retro"]}),u(" Fotógrafo ")]),_:1},8,["href"])])])])):i("",!0),a("main",null,[y(e.$slots,"default")])])])}}};export{de as _};
