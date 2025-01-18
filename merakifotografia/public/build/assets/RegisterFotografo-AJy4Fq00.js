import{T as _,f as b,o as p,l as w,w as c,a as s,u as o,Z as v,b as l,c as x,d as h,m as u,s as y,n as V,h as C}from"./app-Ciu3P-SA.js";import{_ as k}from"./GuestLayout-Cba7f79d.js";import{_ as r,a as n}from"./InputLabel-Boxk0wKV.js";import{P as U}from"./PrimaryButton-CXUH_UH7.js";import{_ as i}from"./TextInput-6cJox-sh.js";import{h as j}from"./heic2any-TgjPBaeP.js";import"./ApplicationLogo-DUo0UlGc.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const R=l("h3",{class:"mt-6 mb-4 text-2xl font-extrabold text-gray-900"},"Crea tu cuenta de fotografo:",-1),B={class:"mb-4"},F={class:"flex flex-col items-center justify-center w-full relative"},I={for:"foto",class:"flex flex-col items-center justify-center w-52 h-52 border-2 border-green-500 border-dashed rounded-full cursor-pointer bg-gray-700 hover:bg-gray-600"},L={class:"flex flex-col items-center justify-center pt-5 pb-6 relative"},N={key:0,class:"absolute w-52 h-52 flex items-center justify-center bg-black border-2 border-green-500 border-dashed rounded-full cursor-pointer overflow-hidden"},E=["src"],$=l("p",{class:"mb-2 text-xs text-white"},[l("span",{class:"font-semibold"},"Click to upload"),u(" or drag and drop")],-1),P={class:"mt-4"},T={class:"mt-4"},O={class:"mt-4"},z={class:"mt-4"},A={class:"mt-4"},D={class:"flex items-center justify-end mt-4"},Q={__name:"RegisterFotografo",setup(G){const e=_({nombre:"",apellidos:"",usuario:"",foto:null,email:"",password:"",password_confirmation:"",currentImage:null,descripcion:"",rol:2}),f=async d=>{const t=d.target.files[0];if(t)if(t.name.split(".").pop().toLowerCase()==="heic"||t.name.split(".").pop().toLowerCase()==="hevc")try{const m=await j({blob:t,toType:"image/png"}),a=new File([m],t.name.split(".")[0]+".png",{type:"image/png"});e.foto=a,e.currentImage=URL.createObjectURL(a)}catch(m){console.error("Error converting HEIC to PNG: ",m)}else e.foto=t,e.currentImage=URL.createObjectURL(t)},g=()=>{e.post(route("register"),{onFinish:()=>e.reset("password","password_confirmation")})};return(d,t)=>{const m=b("font-awesome-icon");return p(),w(k,null,{default:c(()=>[s(o(v),{title:"Register"}),R,l("form",{onSubmit:C(g,["prevent"]),enctype:"multipart/form-data"},[l("div",B,[l("div",null,[s(r,{for:"foto",value:"Foto",class:"text-white"}),l("div",F,[l("input",{type:"file",id:"foto",name:"foto",class:"mt-1 hidden w-full opacity-0 cursor-pointer",onChange:f},null,32),l("label",I,[l("div",L,[o(e).currentImage?(p(),x("div",N,[l("img",{class:"w-full h-full object-contain",src:o(e).currentImage,alt:"Vista previa de la imagen"},null,8,E)])):h("",!0),s(m,{icon:["fas","camera"],class:"text-white text-3xl"}),$])])]),s(n,{message:o(e).errors.foto,class:"mt-2 text-red-500"},null,8,["message"])])]),l("div",null,[s(r,{for:"nombre",value:"Nombre"}),s(i,{id:"nombre",type:"text",class:"mt-1 block w-full",modelValue:o(e).nombre,"onUpdate:modelValue":t[0]||(t[0]=a=>o(e).nombre=a),autofocus:"",autocomplete:"nombre"},null,8,["modelValue"]),s(n,{class:"mt-2",message:o(e).errors.nombre},null,8,["message"])]),l("div",P,[s(r,{for:"apellidos",value:"Apellidos"}),s(i,{id:"apellidos",type:"text",class:"mt-1 block w-full",modelValue:o(e).apellidos,"onUpdate:modelValue":t[1]||(t[1]=a=>o(e).apellidos=a),autocomplete:"apellidos"},null,8,["modelValue"]),s(n,{class:"mt-2",message:o(e).errors.apellidos},null,8,["message"])]),l("div",T,[s(r,{for:"usuario",value:"Usuario"}),s(i,{id:"usuario",type:"text",class:"mt-1 block w-full",modelValue:o(e).usuario,"onUpdate:modelValue":t[2]||(t[2]=a=>o(e).usuario=a),autocomplete:"usuario"},null,8,["modelValue"]),s(n,{class:"mt-2",message:o(e).errors.usuario},null,8,["message"])]),l("div",null,[s(r,{for:"descripcion",value:"Descripcion"}),s(i,{id:"descripcion",type:"text",class:"mt-1 block w-full",modelValue:o(e).descripcion,"onUpdate:modelValue":t[3]||(t[3]=a=>o(e).descripcion=a),autofocus:"",autocomplete:"nombre"},null,8,["modelValue"]),s(n,{class:"mt-2",message:o(e).errors.descripcion},null,8,["message"])]),l("div",O,[s(r,{for:"email",value:"Correo Electrónico"}),s(i,{id:"email",type:"email",class:"mt-1 block w-full",modelValue:o(e).email,"onUpdate:modelValue":t[4]||(t[4]=a=>o(e).email=a),autocomplete:"username"},null,8,["modelValue"]),s(n,{class:"mt-2",message:o(e).errors.email},null,8,["message"])]),l("div",z,[s(r,{for:"password",value:"Contraseña"}),s(i,{id:"password",type:"password",class:"mt-1 block w-full",modelValue:o(e).password,"onUpdate:modelValue":t[5]||(t[5]=a=>o(e).password=a),autocomplete:"new-password"},null,8,["modelValue"]),s(n,{class:"mt-2",message:o(e).errors.password},null,8,["message"])]),l("div",A,[s(r,{for:"password_confirmation",value:"Confirmar Contraseña"}),s(i,{id:"password_confirmation",type:"password",class:"mt-1 block w-full",modelValue:o(e).password_confirmation,"onUpdate:modelValue":t[6]||(t[6]=a=>o(e).password_confirmation=a),autocomplete:"new-password"},null,8,["modelValue"]),s(n,{class:"mt-2",message:o(e).errors.password_confirmation},null,8,["message"])]),l("div",D,[s(o(y),{href:d.route("login"),class:"underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"},{default:c(()=>[u(" ¿Ya tienes una cuenta? ")]),_:1},8,["href"]),s(U,{class:V(["ms-4",{"opacity-25":o(e).processing}]),disabled:o(e).processing},{default:c(()=>[u(" Registrarse ")]),_:1},8,["class","disabled"])])],32)]),_:1})}}};export{Q as default};
