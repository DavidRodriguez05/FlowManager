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
} from "recharts";

function Section2() {
    const [data1, setData1] = useState([]);
    const [data2, setData2] = useState([]);

    useEffect(() => {
        // Función para obtener los datos del gráfico de barras
        const fetchData = () => {
            fetch("http://localhost/TFG-Gestor/src/api/service/getData.php")
                .then((response) => response.json())
                .then((data) => {
                    setData1(data);
                })
                .catch((error) =>
                    console.error("Error al obtener los datos1:", error)
                );
        };

        // Llamar a fetchData cada 5 segundos
        const interval = setInterval(fetchData, 5000);

        // Llamar a fetchData inmediatamente al cargar el componente
        fetchData();

        // Limpiar el intervalo cuando el componente se desmonte
        return () => clearInterval(interval);
    }, []);

    useEffect(() => {
        // Función para obtener los datos del gráfico de líneas
        const fetchData2 = () => {
            fetch("http://localhost/TFG-Gestor/src/api/service/getData2.php")
                .then((response) => response.json())
                .then((data) => {
                    setData2(data);
                })
                .catch((error) =>
                    console.error("Error al obtener los datos2:", error)
                );
        };

        // Llamar a fetchData2 inmediatamente al cargar el componente
        fetchData2();

        // Opcional: Actualizar los datos cada 5 segundos
        const interval = setInterval(fetchData2, 5000);

        // Limpiar el intervalo cuando el componente se desmonte
        return () => clearInterval(interval);
    }, []);

    return (
        <section className="bg-gray-600 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 p-2 gap-3">
            <div className="bg-gray-700 col-span-2 lg:col-span-1 py-3 rounded-lg h-60 w-auto flex flex-col justify-center items-center">
                <h5 className="text-white text-3xl py-2">
                    Proyecto por estado
                </h5>
                <ResponsiveContainer width="100%" height="100%" className="p-3">
                    {data1.length > 0 ? (
                        <BarChart data={data1}>
                            <XAxis dataKey="estado" tick={{ fill: "white" }} />
                            <Tooltip />
                            <Bar dataKey="cantidad" fill="#155DFC" />
                        </BarChart>
                    ) : (
                        <p className="text-white">Cargando datos...</p>
                    )}
                </ResponsiveContainer>
            </div>
            <div className="bg-gray-700 col-span-2 py-3 rounded-lg h-60 w-auto flex flex-col justify-center items-center">
                <h5 className="text-white text-3xl py-2">
                    Distribución de tareas
                </h5>
                <ResponsiveContainer width="100%" height="100%" className="p-3">
                    {data2.length > 0 ? (
                        <LineChart data={data2}>
                            <XAxis dataKey="semana" tick={{ fill: "white" }} />
                            <Tooltip />
                            <Line
                                type="monotone"
                                dataKey="tareas"
                                stroke="#3b82f6"
                                strokeWidth={2}
                            />
                        </LineChart>
                    ) : (
                        <p className="text-white">Cargando datos...</p>
                    )}
                </ResponsiveContainer>
            </div>
        </section>
    );
}

export default Section2;
