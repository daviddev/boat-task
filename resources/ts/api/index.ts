import axios from "axios";

export const fetchModels = async () => {
    const query = `
        query {
            boat_models {
                id
                name
            }
        }
    `;

    const {data: {data}} = await axios.get(`/graphql?query=${query}`);

    return data.boat_models;
};

export const fetchBoats = async (page: number, limit: number, filter: object) => {
    let params = [];

    if (filter) {
        if (filter.model) {
            params.push(`model: ${filter.model}`);
        }
        if (filter.fuel_type) {
            params.push(`fuel_type: "${filter.fuel_type}"`);
        }
        if (filter.condition) {
            params.push(`condition: "${filter.condition}"`);
        }
        if (filter.sort_by_field) {
            params.push(`sort_by_field: "${filter.sort_by_field}"`);
        }
        if (filter.sort_by_type) {
            params.push(`sort_by_type: "${filter.sort_by_type}"`);
        }
    }

    const query = `
        query {
            boats (
                page: ${page},
                limit: ${limit}
                ${params.length ? `, ${params.join(', ')}` : ''}
            ) {
                data {
                    id
                    title
                    price
                    condition
                    fuel_type
                    model {
                        name
                    }
                    images {
                        url
                    }
                }
                last_page
            }
        }
    `;

    const {data: {data}} = await axios.get(`/graphql?query=${query}`);

    return data.boats;
};

export const fetchBoat = async (id: number) => {
    const query = `
        query {
            boat (id: ${id}) {
                id
                year
                beam
                price
                title
                length
                persons
                fuel_type
                condition
                horsepower
                description
                fuel_capacity
                number_of_engines
                model {
                    name
                }
                images {
                    url
                }
            }
        }
    `;

    const {data: {data}} = await axios.get(`/graphql?query=${query}`);

    return data.boat;
};
