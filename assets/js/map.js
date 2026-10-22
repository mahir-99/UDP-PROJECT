// Original AI Studio Google Maps view and camera controller, compiled to JavaScript.
import { React, useState, useEffect, createRoot, APIProvider, Map, AdvancedMarker, Pin, InfoWindow, useMap, MapPin, Navigation } from "./map-runtime.js";
const GUJARAT_CITY_COORDINATES = window.EARTHCYCLE.cityPresets;
const GUJARAT_CENTERS = window.EARTHCYCLE.centers;
const GOOGLE_MAPS_API_KEY = window.EARTHCYCLE.mapKey;
function MapCameraController({
  selectedCenter,
  selectedCityCoords
}) {
  const map = useMap();
  useEffect(() => {
    if (!map) return;
    if (selectedCenter) {
      map.panTo({ lat: selectedCenter.lat, lng: selectedCenter.lng });
      map.setZoom(14);
    } else if (selectedCityCoords) {
      map.panTo({ lat: selectedCityCoords.lat, lng: selectedCityCoords.lng });
      map.setZoom(selectedCityCoords.zoom);
    }
  }, [map, selectedCenter, selectedCityCoords]);
  return null;
}
function MapIsland() {
  const [selectedFacility, updateFacility] = useState(null);
  const [selectedCity, setSelectedCity] = useState("All");
  const [filteredCenters, setFilteredCenters] = useState(GUJARAT_CENTERS);
  const setSelectedFacility = (c) => {
    updateFacility(c);
    window.dispatchEvent(new CustomEvent("earthcycle:map-selection", { detail: c }));
  };
  useEffect(() => {
    const h = (e) => {
      setSelectedCity(e.detail.city);
      setFilteredCenters(e.detail.centers);
      updateFacility(e.detail.selected);
    };
    window.addEventListener("earthcycle:map-state", h);
    window.dispatchEvent(new Event("earthcycle:map-ready"));
    return () => window.removeEventListener("earthcycle:map-state", h);
  }, []);
  return /* @__PURE__ */ React.createElement(APIProvider, { apiKey: GOOGLE_MAPS_API_KEY, libraries: ["marker"] }, /* @__PURE__ */ React.createElement(
    Map,
    {
      mapId: "DEMO_MAP_ID",
      defaultCenter: { lat: 22.5, lng: 72.1 },
      defaultZoom: 8,
      gestureHandling: "greedy",
      disableDefaultUI: false,
      internalUsageAttributionIds: ["gmp_mcp_codeassist_v1_aistudio"],
      style: { width: "100%", height: "100%" }
    },
    /* @__PURE__ */ React.createElement(
      MapCameraController,
      {
        selectedCenter: selectedFacility,
        selectedCityCoords: selectedCity !== "All" ? GUJARAT_CITY_COORDINATES[selectedCity] : null
      }
    ),
    filteredCenters.map((c) => /* @__PURE__ */ React.createElement(
      AdvancedMarker,
      {
        key: c.id,
        position: { lat: c.lat, lng: c.lng },
        title: c.name,
        onClick: () => setSelectedFacility(c)
      },
      /* @__PURE__ */ React.createElement(
        Pin,
        {
          background: c.type.includes("Municipal") ? "#047857" : "#10b981",
          glyphColor: "#ffffff",
          borderColor: "#022c22"
        }
      )
    )),
    selectedFacility && /* @__PURE__ */ React.createElement(
      InfoWindow,
      {
        position: { lat: selectedFacility.lat, lng: selectedFacility.lng },
        onCloseClick: () => setSelectedFacility(null)
      },
      /* @__PURE__ */ React.createElement("div", { className: "p-2 max-w-[280px] font-sans text-slate-900" }, /* @__PURE__ */ React.createElement("span", { className: "inline-block text-[10px] font-bold text-emerald-950 bg-emerald-100 px-2 py-0.5 rounded-full mb-1" }, selectedFacility.badge), /* @__PURE__ */ React.createElement("h4", { className: "font-extrabold text-sm text-slate-950 mb-1" }, selectedFacility.name), /* @__PURE__ */ React.createElement("p", { className: "text-xs text-slate-700 mb-2 leading-relaxed flex items-start gap-1" }, /* @__PURE__ */ React.createElement(MapPin, { className: "w-3.5 h-3.5 text-emerald-700 shrink-0 mt-0.5" }), /* @__PURE__ */ React.createElement("span", null, selectedFacility.address)), /* @__PURE__ */ React.createElement("div", { className: "text-[11px] text-slate-600 mb-1" }, /* @__PURE__ */ React.createElement("strong", null, "Hours:"), " ", selectedFacility.hours), /* @__PURE__ */ React.createElement("div", { className: "text-[11px] text-slate-600 mb-2" }, /* @__PURE__ */ React.createElement("strong", null, "Helpline:"), " ", selectedFacility.phone), /* @__PURE__ */ React.createElement(
        "a",
        {
          href: `https://www.google.com/maps/dir/?api=1&destination=${selectedFacility.lat},${selectedFacility.lng}`,
          target: "_blank",
          rel: "noopener noreferrer",
          className: "inline-flex items-center gap-1 text-xs bg-emerald-800 text-white px-3 py-1.5 rounded-lg font-bold hover:bg-emerald-900 transition"
        },
        /* @__PURE__ */ React.createElement(Navigation, { className: "w-3 h-3" }),
        " Open Driving Directions"
      ))
    )
  ));
}
let root;
function mountMap(element) {
  root = createRoot(element);
  root.render(/* @__PURE__ */ React.createElement(MapIsland, null));
}
function unmountMap() {
  root?.unmount();
  root = null;
}
export {
  mountMap,
  unmountMap
};
