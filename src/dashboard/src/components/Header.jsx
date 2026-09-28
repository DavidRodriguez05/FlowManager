import React from "react";

function Header() {
    const fechaActual = new Date().toLocaleDateString("es-ES", {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
    });
    return (
        <section className="bg-gray-600 p-2">
            <div className="bg-gray-700 text-white p-4 rounded-xl flex flex-row justify-between items-center">
                <h2 className="text-4xl sm:text-5xl">Dashboard</h2>
                <p className="text-lg border-1 p-3 rounded-xl hidden lg:block">
                    {fechaActual}
                </p>
            </div>
        </section>
    );
}

export default Header;
