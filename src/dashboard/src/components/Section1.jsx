import React, { useEffect, useState } from "react";
import { MdOutlineTaskAlt } from "react-icons/md";
import { LuNotebook } from "react-icons/lu";
import { PiBooks } from "react-icons/pi";
import { PiBookmarkSimpleBold } from "react-icons/pi";
import { TbClock2 } from "react-icons/tb";
import { MdLineAxis } from "react-icons/md";

function Section1() {
    const [data3, setData3] = useState(null);
    const [data4, setData4] = useState(null);
    const [data5, setData5] = useState(null);

    useEffect(() => {
        const fetchData3 = () => {
            fetch("http://localhost/TFG-Gestor/src/api/service/getData3.php")
                .then((response) => response.json())
                .then((data) => {
                    setData3(data[0]);
                })
                .catch((error) =>
                    console.error("Error al obtener los datos3:", error)
                );
        };
        fetchData3();
        const interval = setInterval(fetchData3, 5000);
        return () => clearInterval(interval);
    }, []);

    useEffect(() => {
        const fetchData4 = () => {
            fetch("http://localhost/TFG-Gestor/src/api/service/getData4.php")
                .then((response) => response.json())
                .then((data) => {
                    setData4(data[0]);
                })
                .catch((error) =>
                    console.error("Error al obtener los datos4:", error)
                );
        };
        fetchData4();
        const interval = setInterval(fetchData4, 5000);
        return () => clearInterval(interval);
    }, []);

    useEffect(() => {
        const fetchData5 = () => {
            fetch("http://localhost/TFG-Gestor/src/api/service/getData5.php")
                .then((response) => response.json())
                .then((data) => {
                    setData5(data[0]);
                })
                .catch((error) =>
                    console.error("Error al obtener los datos5:", error)
                );
        };
        fetchData5();
        const interval = setInterval(fetchData5, 5000);
        return () => clearInterval(interval);
    }, []);

    return (
        <section className="bg-gray-600 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 p-2 gap-3">
            <div className="flex flex-col col-span-1 justify-center items-center bg-gray-700 p-3 rounded-lg w-auto text-white">
                <LuNotebook className="text-8xl p-1.5" />
                <div className="flex flex-row justify-start items-center">
                    <MdOutlineTaskAlt className="text-4xl mt-1" />
                    <span className="text-6xl ml-2">
                        {data3 ? data3.cantidad : "Cargando..."}
                    </span>
                </div>
                <span className="bg-gray-800 p-2 rounded-lg w-10/12 text-center text-2xl my-1.5">
                    Tareas totales
                </span>
            </div>
            <div className="flex flex-col col-span-1 justify-center items-center bg-gray-700 p-3 rounded-lg w-auto text-white">
                <PiBooks className="text-8xl p-1.5" />
                <div className="flex flex-row justify-start items-center">
                    <MdOutlineTaskAlt className="text-4xl mt-1" />
                    <span className="text-6xl ml-2">
                        {data4 ? data4.cantidad : "Cargando..."}
                    </span>
                </div>
                <span className="bg-gray-800 p-2 rounded-lg w-10/12 text-center text-2xl my-1.5">
                    Proyectos totales
                </span>
            </div>
            <div className="flex flex-col col-span-1 md:col-span-2 lg:col-span-1 justify-start items-center lg:items-start bg-gray-700 p-3 rounded-lg w-auto text-white">
                <h6 className="text-4xl">Proyecto más reciente</h6>
                <div className="flex flex-col justify-start items-start py-2">
                    <div className="flex justify-start items-center my-2">
                        <PiBookmarkSimpleBold className="text-blue-600 text-3xl" />
                        <span className="text-2xl">
                            Título:{" "}
                            {data5 ? data5.nombre_proyecto : "Cargando..."}
                        </span>
                    </div>
                    <div className="flex justify-start items-center my-2">
                        <MdLineAxis className="text-blue-600 text-3xl" />
                        <span className="text-2xl mr-2">Estado:</span>
                        <span
                            className={`text-2xl ${
                                data5 && data5.estado_proyecto === "activo"
                                    ? "text-sky-500"
                                    : data5 &&
                                      data5.estado_proyecto === "pendiente"
                                    ? "text-amber-500"
                                    : data5 &&
                                      data5.estado_proyecto === "completado"
                                    ? "text-green-400"
                                    : "text-white"
                            }`}
                        >
                            {data5 ? data5.estado_proyecto : "Cargando..."}
                        </span>
                    </div>
                    <div className="flex justify-start items-center my-2">
                        <TbClock2 className="text-blue-600 text-3xl" />
                        <span className="text-2xl">
                            Creación:{" "}
                            {data5 ? data5.creacion_proyecto : "Cargando..."}
                        </span>
                    </div>
                </div>
            </div>
        </section>
    );
}

export default Section1;
