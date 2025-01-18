import{_ as h}from"./AuthenticatedLayout-MXKCAcrT.js";import{o as e,c as s,a as d,u as g,w as u,F as c,Z as f,b as t,t as l,g as _,d as y,i as b,p as x,e as v}from"./app-Ciu3P-SA.js";import{_ as w}from"./_plugin-vue_export-helper-DlAUqK2U.js";import"./ApplicationLogo-DUo0UlGc.js";import"./ReportajesForm-CSJmx6Js.js";import"./InputLabel-Boxk0wKV.js";import"./TextInput-6cJox-sh.js";import"./heic2any-TgjPBaeP.js";const m=r=>(x("data-v-5bbb001b"),r=r(),v(),r),k={class:"relative w-full h-72 bg-gradient-to-b from-amethyst-1 via-amethyst-8 to-amethyst-1"},j=["src"],C={class:"relative z-10 flex flex-col items-center justify-center h-full text-white"},S={class:"text-4xl font-bold mb-4"},I=m(()=>t("p",{class:"text-lg font-semibold"},"Explora los reportajes destacados",-1)),$={class:"py-12 bg-gray-100"},A={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},B={key:0,class:"text-center text-xl text-gray-600 py-12"},F={key:1,class:"grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"},N=["onClick"],V=["src"],E={key:1,class:"h-48 bg-gray-200 flex items-center justify-center"},R=m(()=>t("span",{class:"text-gray-500"},"Sin imagen",-1)),z=[R],D={class:"p-4 text-center"},L={class:"text-lg font-semibold text-gray-800 truncate"},O={key:0,class:"text-sm text-amethyst-8"},Z={__name:"Categoria",props:{reportajes:{type:Array,default:()=>[]},categorias:{type:Array,default:()=>[]},categoria:{type:Object,default:()=>{}}},setup(r){const o=r,p=n=>{b.get(route("reportaje.show",n))};return(n,q)=>(e(),s(c,null,[d(g(f),{title:o.categoria.nombre},null,8,["title"]),d(h,null,{default:u(()=>[t("div",k,[t("img",{src:`/imagenes/fotosCategorias/${o.categoria.foto}`,alt:"portada",class:"absolute inset-0 w-full h-full object-cover opacity-50"},null,8,j),t("div",C,[t("h1",S,l(o.categoria.nombre),1),I])]),t("div",$,[t("div",A,[o.reportajes.length===0?(e(),s("div",B," Aún no hay reportajes disponibles. ")):(e(),s("div",F,[(e(!0),s(c,null,_(o.reportajes,a=>(e(),s("div",{key:a.id,class:"bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300"},[a.foto?(e(),s("div",{key:0,onClick:i=>p(a.id),class:"cursor-pointer h-48 overflow-hidden"},[t("img",{src:`/imagenes/fotosReportajes/${a.foto}`,alt:"portada",class:"w-full h-full object-cover hover:scale-110 transition-transform duration-300"},null,8,V)],8,N)):(e(),s("div",E,z)),t("div",D,[t("h3",L,l(a.nombre),1),(e(!0),s(c,null,_(o.categorias,i=>(e(),s("div",{key:i.id},[a.categoria_id===i.id?(e(),s("span",O,l(i.nombre),1)):y("",!0)]))),128))])]))),128))]))])])]),_:1})],64))}},U=w(Z,[["__scopeId","data-v-5bbb001b"]]);export{U as default};
