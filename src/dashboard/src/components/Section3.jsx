import React, { useEffect, useState } from "react";
import {
    BarChart,
    Bar,
    XAxis,
    YAxis,
    Tooltip,
    CartesianGrid,
    ResponsiveContainer,
    LineChart,
    Line,
    PieChart,
    Pie,
    Cell,
} from "recharts";

const COLORS = ["#FE9328", "#8E51FF", "#00C950"];

function Section3() {
    const [data6, setData6] = useState([]);
    const [data7, setData7] = useState([]);

    useEffect(() => {
        const fetchData6 = () => {
            fetch("http://localhost/TFG-Gestor/src/api/service/getData6.php")
                .then((response) => response.json())
                .then((data) => {
                    const formattedData = data.map((item) => ({
                        name: item.estado,
                        value: parseInt(item.cantidad, 10),
                    }));
                    setData6(formattedData);
                })
                .catch((error) =>
                    console.error("Error al obtener los datos6:", error)
                );
        };

        fetchData6();
        const interval = setInterval(fetchData6, 5000); // Actualiza los datos cada 5 segundos
        return () => clearInterval(interval);
    }, []);

    useEffect(() => {
        const fetchData7 = () => {
            fetch("http://localhost/TFG-Gestor/src/api/service/getData7.php")
                .then((response) => response.json())
                .then((data) => {
                    setData7(data); // Actualiza el estado con las últimas tareas
                })
                .catch((error) =>
                    console.error("Error al obtener las últimas tareas:", error)
                );
        };

        fetchData7();
        const interval = setInterval(fetchData7, 5000);
        return () => clearInterval(interval);
    }, []);

    return (
        <section className="bg-gray-600 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 p-2 gap-3">
            <div className="bg-gray-700 col-span-2 p-2 rounded-lg h-75 w-auto flex flex-col justify-center items-center">
                <h5 className="text-white text-3xl py-2">Tipos de tareas</h5>
                <ResponsiveContainer width="100%" height="100%">
                    {data6.length > 0 ? (
                        <PieChart>
                            <Pie
                                data={data6}
                                cx="50%"
                                cy="50%"
                                innerRadius={50}
                                outerRadius={80}
                                dataKey="value"
                                label
                            >
                                {data6.map((entry, index) => (
                                    <Cell
                                        key={`cell-${index}`}
                                        fill={COLORS[index % COLORS.length]}
                                    />
                                ))}
                            </Pie>
                            <Tooltip />
                        </PieChart>
                    ) : (
                        <p className="text-white">Cargando datos...</p>
                    )}
                </ResponsiveContainer>
            </div>
            <div className="bg-gray-700 col-span-2 lg:col-span-1 p-2 rounded-lg h-75 w-auto flex flex-col justify-center items-center">
                <h5 className="text-white text-2xl py-2 sm:text-3xl">
                    Últimas tareas añadidas
                </h5>
                <ul className="text-white list-disc list-inside">
                    {data7.length > 0 ? (
                        data7.map((task, index) => {
                            // Determina el color según el estado de la tarea
                            let estadoColor = "";
                            if (task.estado_tarea === "finalizada") {
                                estadoColor = "#00C950"; // Verde
                            } else if (task.estado_tarea === "suspendida") {
                                estadoColor = "#FE9328"; // Naranja
                            } else if (task.estado_tarea === "progresando") {
                                estadoColor = "#8E51FF"; // Morado
                            }

                            return (
                                <li
                                    key={index}
                                    className="text-lg m-2 my-3 sm:text-xl sm:my-6"
                                >
                                    <strong>{task.titulo_tarea}</strong> -{" "}
                                    <span style={{ color: estadoColor }}>
                                        {task.estado_tarea}
                                    </span>{" "}
                                    -{" "}
                                    {new Date(
                                        task.creacion_tarea
                                    ).toLocaleDateString()}{" "}
                                    {/* Muestra solo la fecha */}
                                </li>
                            );
                        })
                    ) : (
                        <li className="text-lg">No hay tareas recientes</li>
                    )}
                </ul>
            </div>
        </section>
    );
}

export default Section3;
