import React, {useEffect, useState} from 'react';
import Card from '@mui/material/Card';
import {$DisplayMoney} from "../helpers";
import Button from '@mui/material/Button';
import Select from '@mui/material/Select';
import MenuItem from '@mui/material/MenuItem';
import {fetchBoats, fetchModels} from "../api";
import Preloader from "../components/Preloader";
import CardMedia from '@mui/material/CardMedia';
import InputLabel from '@mui/material/InputLabel';
import Typography from '@mui/material/Typography';
import FormControl from '@mui/material/FormControl';
import CardActions from '@mui/material/CardActions';
import CardContent from '@mui/material/CardContent';
import InfiniteScroll from 'react-infinite-scroll-component';

const Index: React.FC = () => {
    const [loading, setLoading] = useState(true);

    const [boats, setBoats] = useState([]);
    const [models, setModels] = useState([]);

    const [filters, setFilters] = useState({
        model: '',
        fuel_type: '',
        condition: '',
        sort_by_field: '',
        sort_by_type: ''
    });

    const [pagination, setPagination] = useState({
        page: 1,
        limit: 20,
        last_page: 1
    });

    useEffect(() => {
        if (Object.values(filters).filter(x => x !== '').length) {
            search().finally(() => {
                setLoading(false);
            });
        } else {
            load().finally(() => {
                setLoading(false);
            });
        }
    }, [filters]);

    const load = async () => {
        if (!models.length) {
            await fetchModels().then(models => {
                setModels(models);
            });
        }

        await fetchBoats(pagination.page, pagination.limit).then(({data, last_page}) => {
            setBoats(data);
            setPagination({
                ...pagination,
                last_page
            });
        });
    };

    const next = async () => {
        await fetchBoats(pagination.page + 1, pagination.limit, filters).then(({data, last_page}) => {
            setBoats([...boats, ...data]);
            setPagination({
                ...pagination,
                page: pagination.page + 1,
                last_page
            });
        });
    };

    const search = async () => {
        setLoading(true);
        await fetchBoats(1, 20, filters).then(({data, last_page}) => {
            setBoats(data);
            setPagination({
                page: 1,
                limit: 20,
                last_page
            });
        });
    };

    const handleChangeFilter = event => {
        const {name, value} = event.target;
        setFilters({
            ...filters,
            [name]: value
        });
    };

    const handleChangeSorting = event => {
        let sort_by_field = '';
        let sort_by_type = '';

        if (event.target.value) {
            sort_by_field = event.target.value.split('-')[0];
            sort_by_type = event.target.value.split('-')[1];
        }

        setFilters({
            ...filters,
            sort_by_field,
            sort_by_type
        });
    };

    return loading ? <Preloader/> : <main className="index-screen">
        <h1 className="title">BOATS FOR SALE</h1>
        <div className="filters">
            <FormControl fullWidth>
                <InputLabel id="filter-model-label-id">Model</InputLabel>
                <Select
                    labelId="filter-model-label-id"
                    onChange={handleChangeFilter}
                    value={filters.model}
                    id="filter-model-id"
                    name="model"
                    label="Model"
                >
                    <MenuItem value="">All</MenuItem>
                    {models.map(model => {
                        return <MenuItem key={`model-${model.id}`} value={model.id}>{model.name}</MenuItem>
                    })}
                </Select>
            </FormControl>
            <FormControl fullWidth>
                <InputLabel id="filter-fuel-type-label-id">Fuel Type</InputLabel>
                <Select
                    labelId="filter-fuel-type-label-id"
                    onChange={handleChangeFilter}
                    value={filters.fuel_type}
                    id="filter-fuel-type-id"
                    name="fuel_type"
                    label="Fuel Type"
                >
                    <MenuItem value="">All</MenuItem>
                    <MenuItem value="petrol">Petrol</MenuItem>
                    <MenuItem value="diesel">Diesel</MenuItem>
                </Select>
            </FormControl>
            <FormControl fullWidth>
                <InputLabel id="filter-condition-label-id">Condition</InputLabel>
                <Select
                    labelId="filter-condition-label-id"
                    onChange={handleChangeFilter}
                    value={filters.condition}
                    id="filter-condition-id"
                    name="condition"
                    label="Condition"
                >
                    <MenuItem value="">All</MenuItem>
                    <MenuItem value="new">New</MenuItem>
                    <MenuItem value="used">Used</MenuItem>
                </Select>
            </FormControl>
            <FormControl fullWidth>
                <InputLabel id="filter-sort-by-label-id">Sort By</InputLabel>
                <Select
                    value={filters.sort_by_field && filters.sort_by_type ? `${filters.sort_by_field}-${filters.sort_by_type}` : ''}
                    labelId="filter-sort-by-label-id"
                    onChange={handleChangeSorting}
                    id="filter-sort-by-id"
                    label="Sort By"
                >
                    <MenuItem value="">All</MenuItem>
                    <MenuItem value="title-asc">Title (A-Z)</MenuItem>
                    <MenuItem value="title-desc">Title (Z-A)</MenuItem>
                    <MenuItem value="model_name-asc">Model (A-Z)</MenuItem>
                    <MenuItem value="model_name-desc">Model (Z-A)</MenuItem>
                    <MenuItem value="fuel_type-asc">Fuel Type (A-Z)</MenuItem>
                    <MenuItem value="fuel_type-desc">Fuel Type (Z-A)</MenuItem>
                    <MenuItem value="condition-asc">Condition (A-Z)</MenuItem>
                    <MenuItem value="condition-desc">Condition (Z-A)</MenuItem>
                </Select>
            </FormControl>
        </div>
        <InfiniteScroll
            hasMore={pagination.page < pagination.last_page}
            dataLength={boats.length}
            loader="Loading"
            next={next}
        >
            <section className="boats">
                {boats.map(boat => {
                    return <Card key={`boat-${boat.id}`}>
                        <CardMedia
                            component="img"
                            alt="green iguana"
                            height="140"
                            image={boat.images[0].url}
                        />
                        <CardContent className="boat-details">
                            <Typography className="boat-title">{boat.title}</Typography>
                            <Typography><span>Model:</span> <span>{boat.model.name}</span></Typography>
                            <Typography><span>Price:</span> <span>{$DisplayMoney(boat.price)}</span></Typography>
                            <Typography><span>Condition:</span> <span>{boat.condition}</span></Typography>
                            <Typography><span>Fuel Type:</span> <span>{boat.fuel_type}</span></Typography>
                        </CardContent>
                        <CardActions>
                            <Button onClick={() => window.location.href = `/show/${boat.id}`} size="small">Show More</Button>
                        </CardActions>
                    </Card>
                })}
            </section>
        </InfiniteScroll>
    </main>
};

export default Index;
