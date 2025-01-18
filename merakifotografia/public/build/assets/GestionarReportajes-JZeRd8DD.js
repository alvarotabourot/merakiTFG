import{r as x,j as y,f as b,o as t,c as o,b as s,k,v as w,F as c,g as d,t as u,d as j,a as C,p as R,e as S,i as g}from"./app-Ciu3P-SA.js";import{_ as I}from"./_plugin-vue_export-helper-DlAUqK2U.js";const f=n=>(R("data-v-c4f65b46"),n=n(),S(),n),N={class:""},V={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},$={class:"mb-8 flex justify-center"},B=f(()=>s("option",{value:null},"Todas las categorías",-1)),F=["value"],A={key:0,class:"text-center text-xl text-gray-600"},D={key:1,class:"grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"},E=["onClick"],G=["src"],L=["onClick"],M=f(()=>s("img",{src:"/imagenes/fotosReportajes/defaultReportaje.jpg",alt:"portada predeterminada",class:"w-full h-full object-cover"},null,-1)),T=[M],U={class:"p-4"},q={class:"text-lg font-semibold text-gray-800 truncate mb-2 text-center"},z={key:0,class:"text-sm text-purple-600 text-center"},H={class:"mt-4 flex justify-center gap-4"},J=["onClick"],K={__name:"GestionarReportajes",props:{reportajes:{type:Array,default:()=>[]},categorias:{type:Array,default:()=>[]}},setup(n){const i=n,l=x(null),p=y(()=>l.value?i.reportajes.filter(r=>r.categoria_id===l.value):i.reportajes),h=r=>{confirm("¿Estás seguro de eliminar el reportaje?")&&g.delete(route("reportaje.destroy",r),{onSuccess:()=>{console.log("Reportaje eliminado con éxito")}})},_=r=>{g.get(route("reportaje.show",r))};return(r,m)=>{const v=b("font-awesome-icon");return t(),o("div",N,[s("div",V,[s("div",$,[k(s("select",{"onUpdate:modelValue":m[0]||(m[0]=e=>l.value=e),class:"block w-1/2 p-3 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 transition duration-300"},[B,(t(!0),o(c,null,d(i.categorias,e=>(t(),o("option",{key:e.id,value:e.id},u(e.nombre),9,F))),128))],512),[[w,l.value]])]),p.value.length?(t(),o("div",D,[(t(!0),o(c,null,d(p.value,e=>(t(),o("div",{key:e.id,class:"bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300"},[e.foto?(t(),o("div",{key:0,onClick:a=>_(e.id),class:"cursor-pointer h-52 bg-gray-200 overflow-hidden"},[s("img",{src:`/imagenes/fotosReportajes/${e.foto}`,alt:"portada",class:"w-full h-full object-cover transition duration-300 hover:scale-105"},null,8,G)],8,E)):(t(),o("div",{key:1,class:"cursor-pointer h-52 bg-gray-200 overflow-hidden",onClick:a=>_(e.id)},T,8,L)),s("div",U,[s("h3",q,u(e.nombre),1),(t(!0),o(c,null,d(i.categorias,a=>(t(),o("div",{key:a.id},[e.categoria_id===a.id?(t(),o("p",z,u(a.nombre),1)):j("",!0)]))),128)),s("div",H,[s("button",{onClick:a=>h(e),class:"text-red-600 hover:text-red-800 transition duration-300"},[C(v,{icon:["fas","trash"],class:"text-xl"})],8,J)])])]))),128))])):(t(),o("div",A," No se encontraron reportajes para esta categoría. "))])])}}},Q=I(K,[["__scopeId","data-v-c4f65b46"]]);export{Q as default};
